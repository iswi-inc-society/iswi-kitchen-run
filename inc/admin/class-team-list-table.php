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

    private $teams_per_page;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name           The name of this plugin.
     * @param string $version               The version of this plugin.
     * @param string $plugin_text_domain    The text domain of this plugin.
     * @param array  $args
     * @since       1.0.0
     */
    public function __construct( $teams_per_page, $plugin_text_domain, $args = array() ) {

        $this->teams_per_page = $teams_per_page;
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
            'team_food_pref'    => __( 'Food', $this->plugin_text_domain),
            'team_course_pref'  => __( 'Course', $this->plugin_text_domain),
            'team_valid'        => __( 'Valid', $this->plugin_text_domain),
            'team_photo_agreement'=>__( 'Photos', $this->plugin_text_domain),
            'ext'               => ''
        );
        return $table_columns;
    }

	/**
	 * Get sortable columns. Creates link in the header of the column.
	 * Sort Algorithm implemented in prepare_items().
	 *
	 * @since   1.0.0
	 * @return  array  Columns that can be sorted.
	 */
	protected function get_sortable_columns() {
		$sortable_columns = array (
			'team_name' => array('team_name', true),
		);
		return $sortable_columns;
	}

    /**
     * Bring the properties of the teams from the database into a form that can be displayed by the table.
     * The items are saved in an array with the names of the columns that are written in get_columns(). Prior to rendering.
     *
     * @since 1.0.0
     * @return bool
     */
    public function prepare_items()
    {

        /**
         * Filter Teams by Team
         * @var Team[] $teams
         */
        if (isset($_GET['event'])) { // event set by filter
            $teams = Team::findByEvent(Event::findbyId($_GET['event']));
        } else { // standard event is the current event
            $teams = Team::findByEvent(Event::findCurrent());
        }

        if (!isset($teams)) {
            return false;
        }



        $table_data = array();
        $table_extended = array();

        $image_dir = "/wp-content/plugins/iswi-kitchen-run/assets/images/";

        // process each team object
        foreach ($teams as $team) {
            // Member Names
            $member2 = $team->getMember2();
            $members = $team->getMember1().(isset($member2) ? '<br>'.$member2 : ''); // both members in one column with break

            // food preferences with icons
            $food_pref = '';
            if ($team->getVegan()) $food_pref .= '<img src="' . $image_dir . 'leaf.png' . '" alt="' . 'vegan' . '" />';
            if ($team->getVegetarian()) $food_pref .= '<img src="' . $image_dir . 'milk.png' . '" alt="' . 'vegetarian' . '" />';
            if ($team->getKosher()) $food_pref .= '<img src="' . $image_dir . 'kosher.png' . '" alt="' . 'kosher' . '" />';
            if ($team->getHalal()) $food_pref .= '<img src="' . $image_dir . 'halal.png' . '" alt="' . 'halal' . '" />';
            if ($food_pref == '') $food_pref .= '<img src="' . $image_dir . 'beef.png' . '" alt="' . 'all' . '" />';

            // course preference with icons
            $course_pref = '';
            if ($team->getAppetizer()) $course_pref .= '<img src="' . $image_dir . 'soup.png' . '" alt="' . 'appetizer' . '" />';
            if ($team->getMainCourse()) $course_pref .= '<img src="' . $image_dir . 'food-tray.png' . '" alt="' . 'main course' . '" />';
            if ($team->getDessert()) $course_pref .= '<img src="' . $image_dir . 'ice-creams.png' . '" alt="' . 'dessert' . '" />';

            $valid = '';
            if ($team->getValid()) $valid .= '<img src="' . $image_dir . 'checked.png' . '" alt="' . 'valid' . '"/>';
            else $valid .= '<img src="' . $image_dir . 'cancel.png' . '" alt="' . 'not valid' . '"/>';

            $photo_agreement = '';
	        if ($team->agreedToPhotos()) $photo_agreement .= '<img src="' . $image_dir . 'checked.png' . '" alt="' . 'valid' . '"/>';
	        else $photo_agreement .= '<img src="' . $image_dir . 'cancel.png' . '" alt="' . 'not valid' . '"/>';

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
                'team_valid'    => $valid,
                'team_photo_agreement' => $photo_agreement,
                'ext'           => '<span class="dashicons dashicons-arrow-down-alt2 kr_teams_extend"></span>',
                'extended'      => array(
	                'team_find_place' => array("desc" => __("Find Place", $this->plugin_text_domain) ,"val" => $team->getFindPlace() != '' ? $team->getFindPlace() : '-'),
	                'team_food_request' => array("desc" => __("Food Request", $this->plugin_text_domain) ,"val" => $team->getFoodRequest() != '' ? $team->getFoodRequest() : '-'),
	                'team_comment' => array("desc" => __("Comment", $this->plugin_text_domain) ,"val" => $team->getComments() != '' ? $team->getComments() : '-'),
                    'team_link' => array("desc" => __("Link", $this->plugin_text_domain), "val" => $team->getLink() != null ? $team->getLink() : '-'),
                )
            );
        }

	    // set up multiple site table with maximal 10 teams per page
	    $per_page = $this->teams_per_page;
	    $this->set_pagination_args( array(
		    'total_items' => count($teams),                  //WE have to calculate the total number of items
		    'per_page'    => $per_page                     //WE have to determine how many items to show on a page
	    ) );

	    $page = isset($_GET['paged']) ? $_GET['paged'] : 1; //what page number are we on?

	    usort($table_data, array($this, "cmp_sort_asc"));
        $this->items = array_slice($table_data, ($page-1)*$per_page, $per_page); // save in items -> rows

        return true;
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
            case 'team_valid':
            case 'team_photo_agreement':
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

	public function single_row( $item ) {

		echo '<tr class="kr-team-row">';
		$this->single_row_columns( $item );
		echo '</tr>';

		//var_dump($item);

		echo '<tr class="kr-extended-row display-none"><td></td>';

		foreach ($item['extended'] as $key => $item_e) {
            echo sprintf('
                <td class="colspanchange %s" colspan="2">
                    <div class="kr-tl-cell-inner">
                        <span class="kr-tl-desc">%s</span>
                        <p class="kr-tl-val">%s</p>
                    </div>
                </td>
            ', $key, $item_e['desc'], $item_e['val']);
        }
        echo '<td class="colspanchange" colspan="3"></td>';
		echo '</tr>';


	}

	/**
	 * Callable sort function to sort the team arrays
     * @param array $team1
     * @param array $team2
     * @return bool
	 */
	private function cmp_sort_asc($team1, $team2) {
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'team_name';
		// If no order, default to asc
		$order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
		// Determine sort order
		$result = strcmp( $team1[$orderby], $team2[$orderby] );
		// Send final sort direction to usort
		return ( $order === 'asc' ) ? $result : -$result;
    }

}