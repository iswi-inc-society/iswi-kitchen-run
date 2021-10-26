<?php
namespace KitchenRun\Inc\Common\Model;

/**
 * Class Database.
 * Has Functions to create the db tables when the plugin is activated and to delete the tables when the plugin is deleted.
 * Defines names of the tables.
 *
 * @TODO        write general save and delete function to use in models (maybe in model class)
 * @TODO        write general findALl and find functions to use in models (maybe in model class)
 * @since       1.0.0
 * @package     KitchenRun\Inc\Common\Model
 * @author      Niklas Loos <niklas.loos@live.com>
 */
class Database {

    /**
     * Name of the DB Table that saves all kitchenrun teams.
     *
     * @since   1.0.0
     * @var     string  DB_TEAM_NAME
     */
    const DB_TEAM_NAME = "kr_team";

    /**
     * Name of the DB Table that saves all kitchenrun course pairs.
     *
     * @since   1.0.0
     * @var     string  DB_PAIR_NAME
     */
    const DB_PAIR_NAME = "kr_pair";

    /**
     * Name of the DB Table that saves all kitchenrun events.
     *
     * @since   1.0.0
     * @var     string  DB_EVENT_NAME
     */
    const DB_EVENT_NAME = "kr_event";

    /**
     * Search for a single row or several rows in Database.
     *
     * e.g. search for a team by id -> findBy('kr_team', 'id', $id)
     *
     * @since   1.0.0
     * @param   string  $table    Name of Table in DB
     * @param   string  $column   Name of column in the table where we search
     * @param   string  $value    Value that is searched for in that column
     * @param   bool    $single   Search for a single row (or multiple rows, then false)
     * @return  array|object|void|null   Array with Output of searched row in database table
     */
    public function findBy($table, $column, $value, $single = true) {

        global $wpdb; // wordpress database object

        $databaseName =  DB_NAME;
        $prefix = $wpdb->prefix;

        // sql query find row with id
        $sql = sprintf("SELECT * FROM %s%s WHERE %s='%s';", $prefix, $table, $column, $value);

        if ($single) { return $wpdb->get_row($sql); } // query for a single row
        else { return $wpdb->get_results($sql); } // query for several rows


    }

    /**
     * Searches for all rows in a DB table.
     *
     * @since   1.0.0
     * @param   string  $table      Name of Table in DB
     * @return  array|object|null   Array with Output of all rows of the table
     */
    public function findAll($table) {

        global $wpdb; // wordpress database object

        $databaseName =  DB_NAME;
        $prefix = $wpdb->prefix;

        // sql query find row with id
        $sql = sprintf("SELECT * FROM %s%s", $prefix, $table);

        return $wpdb->get_results($sql);  // query for several rows

    }

    /**
     * Deletes a specific Row by ID in a table in DB
     *
     * @since   1.0.0
     * @param   string  $table  Table Name where row should be deleted
     * @param   int     $id     ID of row that will be deleted
     */
    public function deleteRow($table, $id) {
        global $wpdb;

        $table_name = $wpdb->prefix . $table;

        $wpdb->delete( $table_name, array( 'id' => $id ) );
    }

    /**
     * Save Row in DB
     *
     * Saves a row in Database Table either as new row or update old row. If existing row should be updated add the row
     * id in the function constructor as $id and not in the row.
     *
     * @since   1.0.0
     * @param   string  $table  Table Name where row should be saved
     * @param   array   $row    Array with all columns of the table and values of the row (NO ID, see $id)
     * @param   array   $format Array with formats for each columns (%d for digits and %s for strings)
     * @param   int     $id     ID of existing row to update it (DON'T ADD IT TO THE ROW)
     */
    public function saveRow($table, $row, $format, $id) {
        global $wpdb;

        $table_name = $wpdb->prefix . $table;

        if ($id !== NULL) { // edit old row
            $row["id"] = $id;
            $format[] = '%d';

            $wpdb->replace($table_name, $row, $format);

            return $id;

        } else {
            // save in database as new row
            $wpdb->insert(
                $table_name,
                $row,
                $format
            );
            return $wpdb->insert_id;
        }
    }

    /**
     * Creates a Database Table for all kitchen run teams with an SQL Query.
     *
     * @since 1.0.0
     */
    public function kr_team_install() {

        // Database Query
        $sql ='
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            event mediumint(9) NOT NULL,
            name tinytext NOT NULL,
            member1 tinytext NOT NULL,
            member2 tinytext NULL,
            address tinytext NOT NULL,
            city tinytext NOT NULL,
            email tinytext NOT NULL,
            telephone tinytext NOT NULL,
            vegan tinyint(1) NOT NULL,
            vegetarian tinyint(1) NOT NULL,
            halal tinyint(1) NOT NULL,
            kosher tinyint(1) NOT NULL,
            food_requests text NULL,
            find_place text NULL,
            comments text NULL,
            appetizer tinyint(1) NOT NULL,
            main_course tinyint(1) NOT NULL,
            dessert tinyint(1) NOT NULL,
            valid tinyint(1) NOT NULL DEFAULT 0,
            token varchar(255) DEFAULT NULL,
            iswi tinyint(1) NOT NULL DEFAULT 0,
            link varchar(255) NULL,'
        ;

        $this->db_install($sql, self::DB_TEAM_NAME); // table creation algorithm
    }

    /**
     * Creates a Database Table for all kitchen run course pairs with an SQL Query.
     *
     * @since 1.0.0
     */
    public function kr_pair_install() {

        // Database Query
        $sql ='
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            event mediumint(9) NOT NULL,
            course tinytext NOT NULL,
            cook mediumint(9) NOT NULL,
            guest1 mediumint(9) NOT NULL,
            guest2 mediumint(9) NULL,'
        ;

        $this->db_install($sql, self::DB_PAIR_NAME); // table creation algorithm
    }

    /**
     * Creates a Database Table for all kitchen run events with an SQL Query.
     *
     * @since 1.0.0
     */
    public function kr_event_install()
    {
        // Database Query
        $sql ="
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name tinytext NOT NULL,
            current mediumint(9) NOT NULL DEFAULT '1',
            opening_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            closing_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            event_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            manager bigint(20) NOT NULL,
            paired mediumint(9) NOT NULL DEFAULT '0',
            online tinyint(1) NOT NULL DEFAULT '0',"
        ;

        $this->db_install($sql, self::DB_EVENT_NAME); // table creation algorithm
    }

    /**
     * Deletes the Database Table for all kitchen run teams.
     *
     * @since 1.0.0
     */
    public function kr_team_uninstall()
    {
        $this->db_uninstall(self::DB_TEAM_NAME);
    }

    /**
     * Deletes the Database Table for all kitchen run course pairs.
     *
     * @since 1.0.0
     */
    public function kr_pair_uninstall()
    {
        $this->db_uninstall(self::DB_PAIR_NAME);
    }

    /**
     * Deletes the Database Table for all kitchen run events.
     *
     * @since 1.0.0
     */
    public function kr_event_uninstall()
    {
        $this->db_uninstall(self::DB_EVENT_NAME);
    }

    /**
     * Deletes a Database Table.
     *
     * @since   1.0.0
     *
     * @var     string  $table  table name of table that will be deleted
     */
    private function db_uninstall($table) {
        global $wpdb; // has the prefix

        $table_name = $wpdb->prefix.$table;

        // Database Query
        $sql = "DROP TABLE ".DB_NAME.".".$table_name.";";

        $wpdb->query($sql);
    }

    /**
     * Creates a new Database Table.
     *
     * @since   1.0.0
     *
     * @var     string  $sql    SQL Query as string that has all columns of the table (not more)
     * @var     string  $table  table name of new table
     */
    private function db_install($sql, $table) {

        global $wpdb; // has the prefix

        $table_name = $wpdb->prefix.$table;

        $charset_collate = $wpdb->get_charset_collate();

        // sql query
        $sql_f = "CREATE TABLE $table_name ("
            .$sql."
            PRIMARY KEY  (id)
            ) $charset_collate;"
        ;

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta( $sql_f ); // runs the sql query
    }
}
