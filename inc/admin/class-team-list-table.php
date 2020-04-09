<?php


namespace KitchenRun\Inc\Admin;


use KitchenRun\Inc\Common\Model\Event;
use KitchenRun\Inc\Common\Model\Team;
use KitchenRun\Inc\Libraries\WP_List_Table;

/**
 * Class Team_List_Table
 * Creates a Table with all teams of an event.
 * Extends the WP_LIST_TABLE which creates the standard wordpress backend tables.
 *
 * @author Niklas Loos <niklas.loos@live.com>
 * @package KitchenRun\Inc\Admin
 * @since 1.0.0
 */
class Team_List_Table extends WP_List_Table
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The text domain of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_text_domain    The text domain of this plugin.
     */
    private $plugin_text_domain;


    /**
     * Event Object to create the new event
     *
     * @since   1.0.0
     * @access  private
     * @var     Event   $event
     */
    private $event;


    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name           The name of this plugin.
     * @param string $version               The version of this plugin.
     * @param string $plugin_text_domain    The text domain of this plugin.
     * @param array  $args
     * @since       1.0.0
     */
    public function __construct( $plugin_name, $version, $plugin_text_domain, $args = array() ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->plugin_text_domain = $plugin_text_domain;

        if (isset($_GET['event'])) { // event set by filter
            $this->event = Event::findbyId($_GET['event']);
        } else { // standard event is the current event
            $this->event = Event::findCurrent();
        }

        parent::__construct($args);

    }

    /**
     * Array of Table Columns.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_columns() {
        $table_columns = array(
            'cb'		        => '<input type="checkbox" />', // to display the checkbox.
            'team_name'	        => __( 'Team Name',$this->plugin_text_domain ),
            'team_members'	    => __( 'Members', $this->plugin_text_domain ),
            'team_address'      => __( 'Address', $this->plugin_text_domain ),
            'team_city'         => __( 'City', $this->plugin_text_domain),
            'team_phone'        => __( 'Telephone', $this->plugin_text_domain),
            'team_email'        => __( 'E-Mail', $this->plugin_text_domain),
            'team_food_pref'    => __( 'Food Preferences', $this->plugin_text_domain),
            'team_course_pref'  => __( 'Course Preferences', $this->plugin_text_domain),
        );
        return $table_columns;
    }

    /**
     * Bring the properties of the teams from the database into a form that can be displayed by the table.
     * The items are saved in an array with the names of the columns that are written in get_columns(). Prior to rendering.
     *
     * @since 1.0.0
     */
    public function prepare_items()
    {

        /**
         * @var Team[] $teams
         */
        if (isset($_GET['event'])) { // event set by filter
            $teams = Team::findByEvent(Event::findbyId($_GET['event']));
        } else { // standard event is the current event
            $teams = Team::findByEvent(Event::findCurrent());
        }

        $table_data = array();

        $image_dir = "/wp-content/plugins/iswi-kitchen-run/assets/images/";

        // process each team object
        foreach ($teams as $team) {
            // Member Names
            $member2 = $team->getMember2();
            $members = $team->getMember1().(isset($member2) ? '<br>'.$member2 : ''); // both members in one column with break

            // food preferences with icons
            $food_pref = '';
            if ($team->getVegan()) $food_pref .= '<img src="' . $image_dir . 'leaf.png' . '" alt="' . 'vegan' . '" />';
            else if ($team->getVegetarian()) $food_pref .= '<img src="' . $image_dir . 'milk.png' . '" alt="' . 'vegetarian' . '" />';
            else if ($team->getKosher()) $food_pref .= '<img src="' . $image_dir . 'kosher.png' . '" alt="' . 'kosher' . '" />';
            else if ($team->getHalal()) $food_pref .= '<img src="' . $image_dir . 'halal.png' . '" alt="' . 'halal' . '" />';
            else $food_pref .= '<img src="' . $image_dir . 'beef.png' . '" alt="' . 'all' . '" />';

            // course preference with icons
            $course_pref = '';
            if ($team->getAppetizer()) $course_pref .= '<img src="' . $image_dir . 'soup.png' . '" alt="' . 'appetizer' . '" />';
            if ($team->getMainCourse()) $course_pref .= '<img src="' . $image_dir . 'food-tray.png' . '" alt="' . 'main course' . '" />';
            if ($team->getDessert()) $course_pref .= '<img src="' . $image_dir . 'ice-creams.png' . '" alt="' . 'dessert' . '" />';

            // array with data for the table rows
            $table_data[] = array(
                'cb'            => '<input type="checkbox" />',
                'team_id'       => $team->getId(),
                'team_name'     => $team->getName(),
                'team_members'  => $members,
                'team_address'  => $team->getAddress(),
                'team_city'     => $team->getCity(),
                'team_phone'    => $team->getPhone(),
                'team_email'    => $team->getEmail(),
                'team_food_pref'=> $food_pref,
                'team_course_pref' => $course_pref,
            );
        }

        $this->items = $table_data; // save in items -> rows
    }

    /**
     * Referer to Add Team page.
     *
     * @since   1.0.0
     * @return  string  Get arguments that point to team_update_page() in Team_Page.
     */
    public function get_new_team_link() {
        return "?page=".$_REQUEST['page']."&action=add";
    }

    /**
     * Actions for each table row. To Edit or Delete Teams.
     *
     * @since   1.0.0
     * @param   $item
     * @return  string
     */
    public function column_team_name($item){
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&team=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['team_id']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&team=%s&_wpnonce=%s">Delete</a>',$_REQUEST['page'], 'delete', $item['team_id'], wp_create_nonce('delete_team')),
        );

        //Return the title contents
        return $item['team_name']. $this->row_actions($actions);
    }

    /**
     * Defines default values for each column if an item doesn't have a value for this column.
     *
     * @since   1.0.0
     * @param   object  $item
     * @param   string  $column_name
     * @return  string
     */
    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'team_name':
            case 'team_members':
            case 'team_address':
            case 'team_city':
            case 'team_phone':
            case 'team_email':
            case 'team_food_pref':
            case 'team_course_pref':
            default:
                return $item[$column_name];
        }
    }

    /**
     * Renders a Dropdown to filter Events and show teams of events that are not current.
     *
     * @TODO    Use WP_NONCE to validate request.
     * @since   1.0.0
     */
    public function event_dropdown() {
        /** @var Event $current_event */
        $current_event = Event::findCurrent();

        /** @var Event[] $events */
        $events = Event::findAll();

        $displayed_event = isset( $_GET['event'] ) ? $_GET['event'] : $current_event->getId(); // set default option
        ?>
        <form id="team_list_filter" name="team_filter" method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page']?>">
            <label for="filter-by-event" class="screen-reader-text"><?php _e( 'Filter by event' ); ?></label>
            <select name="event" id="filter-by-event">
                <?php // create for each event an option
                foreach ( $events as $event ) {
                    ?>
                    <option<?php selected( $displayed_event, $event->getId() ); ?> value="<?php echo $event->getId(); ?>"><?php echo $event->getName(); ?></option>
                    <?php
                }
                ?>
            </select>
            <?php submit_button( __( 'Filter' ), 'submit', 'filter_action', false, array( 'id' => 'post-query-submit' ) ); ?>
        </form>
        <?php
    }

    /**
     * Renders a Table navigation over or under the table.
     * Used to create the filter event navigation and the pair/unpair button.
     *
     * @TODO    Unpair Button and Unpair algorithm.
     * @since   1.0.0
     * @param   string  $which  'top' or 'bottom' defines the place for navigation
     */
    protected function extra_tablenav($which)
    {
        ?>
        <div class="alignleft actions">
            <?php
            if ('top' === $which) {
                ob_start();

                $this->event_dropdown(); // render dropdown

                $output = ob_get_clean();

                echo $output;

                if ($this->event->getPaired()) { // unpair button
                    ?>
                    <a class="button submit" href="?page=<?php echo $_REQUEST['page'] ?>&action=unpair"> <?php echo __('Unpair Teams', $this->plugin_text_domain); ?> </a>
                    <?php
                } else { // pair button
                    ?>
                    <a class="button submit" href="?page=<?php echo $_REQUEST['page'] ?>&action=pair"> <?php echo __('Pair Teams', $this->plugin_text_domain); ?> </a>
                    <?php
                }

            }

            ?>
        </div>
        <?php
    }

    /**
     * Get value for checkbox column. Value is the team id.
     *
     * @since   1.0.0
     * @param   object  $item   A row's data.
     * @return  string  Text to be placed inside the column <td>.
     */
    protected function column_cb( $item ) {
        return sprintf(
            '<label class="screen-reader-text" for="team_'.$item['team_id'].'"></label>'
            . "<input type='checkbox' name='teams[]' id='team_".$item['team_id']." ' value='".$item['team_id']."' />"
        );
    }

}