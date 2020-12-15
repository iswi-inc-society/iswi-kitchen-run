<?php


namespace KitchenRun\Inc\Admin;


use KitchenRun\Inc\Libraries\WP_List_Table;
use KitchenRun\Inc\Common\Model\Event;

/**
 * Class Event_List_Table
 * Creates a Table with all events.
 * Extends the WP_LIST_TABLE which creates the standard wordpress backend tables.
 *
 * @author Niklas Loos <niklas.loos@live.com>
 * @package KitchenRun\Inc\Admin
 * @since 1.0.0
 */
class Event_List_Table extends WP_List_Table
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
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @param string $plugin_text_domain The text domain of this plugin.
     * @param array  $args
     * @since       1.0.0
     */
    public function __construct($plugin_text_domain, $args = array() ) {

        $this->plugin_text_domain = $plugin_text_domain;

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
            'cb'		    => '<input type="checkbox" />', // to display the checkbox.
            'event_name'	=> __( 'Event Name', $this->plugin_text_domain ),
            'opening_date'	=> __( 'Opening Date', $this->plugin_text_domain ),
            'closing_date'  => _x( 'Closing Date', 'column name', $this->plugin_text_domain ),
            'event_date'    => __( 'Event Date', $this->plugin_text_domain ),
            'manager'       => __( 'Event Manager', $this->plugin_text_domain),
            'paired'        => __( 'Paired', $this->plugin_text_domain),
        );
        return $table_columns;
    }

    /**
     * Bring the properties of the teams from the database into a form that can be displayed by the table.
     * The items are saved in an array with the names of the columns that are written in get_columns(). Prior to rendering.
     *
     * @since 1.0.0
     */
    public function prepare_items() {

        /** @var Event[] $events */
        $events = Event::findAll();

        // sort table by event_name column
        if (isset($_GET['orderby']) && $_GET['orderby'] == 'event_name') {
            if ($_GET['order'] == 'asc') {
                usort($events, array($this, "cmp"));
            } else if ($_GET['order'] == 'desc') {
                usort($events, array($this, "revcmp"));
            }
        }

        // code to handle data operations like sorting and filtering
        $table_data = array();

        $image_dir = "/wp-content/plugins/iswi-kitchen-run/assets/images/";

        foreach ($events as $event) {

            $table_data[] = array(
                'cb'		    => '<input type="checkbox" />', // to display the checkbox.
                'id'            => $event->getId(),
                'current'       => $event->getCurrent(),
                'event_name'    => $event->getName(),
                'opening_date'  => $event->getOpeningDate()->format('d.m.Y H:m'),
                'closing_date'  => $event->getClosingDate()->format('d.m.Y H:m'),
                'event_date'    => $event->getEventDate()->format('d.m.Y H:m'),
                'manager'       => $event->getManager()->display_name,
                'paired'        => $event->getPaired() ? '<img src="'.$image_dir.'checked.png'.'" alt="tick" />' : '<img src="'.$image_dir.'cancel.png'.'" alt="cross" />',
            );
        }

        // start by assigning your data to the items variable
        $this->items = $table_data;
    }

    /**
     * Edits a single row. Used to color the current Event row blue.
     *
     * @since 1.0.0
     * @param   object  $item
     */
    public function single_row( $item ) {
        if ($item['current']) echo '<tr class="current">'; else echo '<tr>';
        $this->single_row_columns( $item );
        echo '</tr>';
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
            case 'event_name':
            case 'opening_date':
            case 'closing_date':
            case 'event_date':
            case 'manager':
            default:
                return $item[$column_name];
        }
    }

    /**
     * Actions for each table row. To Edit or Delete Event.
     *
     * @since   1.0.0
     * @param   $item
     * @return  string
     */
    public function column_event_name($item){
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&event=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&event=%s&_wpnonce=%s">Delete</a>',$_REQUEST['page'], 'delete', $item['id'], wp_create_nonce('delete_event')),
        );

        //Return the title contents
        return $item['event_name']. $this->row_actions($actions);
    }

    /**
     * Referer to Add Event page.
     *
     * @since   1.0.0
     * @return  string  Get arguments that point to init() in Event_New.
     */
    public function get_new_event_link() {
        return "?page=".$_REQUEST['page']."_add_event";
    }

    /**
     * Get value for checkbox column. Value is the event id.
     *
     * @since   1.0.0
     * @param   object  $item   A row's data.
     * @return  string  Text to be placed inside the column <td>.
     */
    protected function column_cb( $item ) {
        return sprintf(
            '<label class="screen-reader-text" for="event_'.$item['id'].'"></label>'
            . "<input type='checkbox' name='events[]' id='event_".$item['id']." ' value='".$item['id']."' />"
        );
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
            'event_name' => array('event_name', true),
        );
        return $sortable_columns;
    }

    /**
     * Sort Table by Event Name
     *
     * @param   Event $a
     * @param   Event $b
     * @return  int
     */
    protected function cmp($a, $b)
    {
        if ($a->getName() == $b->getName()) {
            return 0;
        }
        return ($a->getName() < $b->getName()) ? -1 : 1;
    }

    /**
     * Reverse Sort Table by Event Name
     *
     * @param   Event $a
     * @param   Event $b
     * @return  int
     */
    protected function revcmp($a, $b)
    {
        if ($a->getName() == $b->getName()) {
            return 0;
        }
        return ($a->getName() < $b->getName()) ? 1 : -1;
    }

}