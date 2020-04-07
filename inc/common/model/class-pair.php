<?php


namespace KitchenRun\Inc\Common\Model;

/**
 * Class Pair
 *
 * Model of a Pair that is saved in the Database or newly created. Pairs are three Teams with one cook and two guests
 * for one course.
 *
 * @since       1.0.0
 * @package     KitchenRun\Inc\Common\Model
 * @author      Niklas Loos <niklas.loos@live.com>
 */
class Pair
{
    /**
     * Name of the Database Table that is used to save the pairs.
     *
     * @since   1.0.0
     * @var     string  TABLE_NAME
     */
    const TABLE_NAME = 'kr_pair';

    /**
     * ID of the Pair. Autogenerated by the DB.
     *
     * @since   1.0.0
     * @access  private
     * @var     int $id
     */
    private $id;

    /**
     * ID of the Event for which the pair was created.
     *
     * @since   1.0.0
     * @access  private
     * @var     int $event
     */
    private $event;

    /**
     * Course in that the pair is participating.
     * '1' -> Appetizer
     * '2' -> Main Course
     * '3' -> Dessert
     *
     * @since   1.0.0
     * @access  private
     * @var     int $course
     */
    private $course;

    /**
     * ID of the Team that cooks the course.
     *
     * @since   1.0.0
     * @access  private
     * @var     int $cook
     */
    private $cook;

    /**
     * ID of the Team that is guest 1 during this course.
     *
     * @since   1.0.0
     * @access  private
     * @var     int $guest1
     */
    private $guest1;

    /**
     * ID of the Team that is guest 2 during this course.
     *
     * @since   1.0.0
     * @access  private
     * @var     int $guest2
     */
    private $guest2;

    /**
     * Get Pair ID.
     *
     * @since   1.0.0
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the Kitchen Run Event in that the pair is taking place.
     *
     * @since   1.0.0
     * @return  Event
     */
    public function getEvent() {
        return Event::findbyId($this->event);
    }

    /**
     * Set the Event in which the pair is taking place.
     *
     * @since   1.0.0
     * @param   Event $event
     */
    public function setEvent($event) {
        $this->event = $event->getId();
    }

    /**
     * Get the Course that the pair is eating.
     * '1' -> Appetizer
     * '2' -> Main Course
     * '3' -> Dessert
     *
     * @since   1.0.0
     * @return  int
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set the Course that the pair is eating.
     * '1' -> Appetizer
     * '2' -> Main Course
     * '3' -> Dessert
     *
     * @since   1.0.0
     * @param   int $course
     */
    public function setCourse($course)
    {
        $this->course = $course;
    }

    /**
     * Get the Team that cooks during this pair.
     *
     * @since   1.0.0
     * @return  Team    Team Object
     */
    public function getCook()
    {
        $cook = Team::findById($this->cook);

        return $cook;
    }

    /**
     * Set the Team that cooks during this pair.
     *
     * @since   1.0.0
     * @param   Team    $cook    Team Object
     */
    public function setCook($cook)
    {
        $this->cook = $cook->getId();
    }

    /**
     * Get the first Guest Team that can just eat during this pair.
     *
     * @since   1.0.0
     * @return  Team    Team Object
     */
    public function getGuest1()
    {
        $guest1 = Team::findById($this->guest1);
        return $guest1;
    }

    /**
     * Set the first Guest Team that can just eat during this pair.
     *
     * @since   1.0.0
     * @param   Team    $guest1     Team Object
     */
    public function setGuest1($guest1)
    {
        $this->guest1 = $guest1->getId();
    }

    /**
     * Get the second Guest Team that can just eat during this pair.
     *
     * @since   1.0.0
     * @return  Team    Team Object
     */
    public function getGuest2()
    {
        $guest2 = Team::findById($this->guest2);
        return $guest2;
    }

    /**
     * Set the second Guest Team that can just eat during this pair.
     *
     * @since   1.0.0
     * @param   Team    $guest2     Team Object
     */
    public function setGuest2($guest2)
    {
        $this->guest2 = $guest2->getId();
    }

    /**
     * Find a list of Pairs in the Database through the event, where they take place.
     *
     * @since   1.0.0
     * @param   Event   $event  Event Object
     * @return  Pair[]  $pairs  Array of Pair Objects
     */
    public static function findByEvent(Event $event) {
        $id = $event->getId();

        global $wpdb;

        $table = self::TABLE_NAME;
        $databaseName =  DB_NAME;
        $prefix = $wpdb->prefix;

        // sql query find row with id
        $sql = "
            SELECT * FROM $databaseName.$prefix$table WHERE event='$id';
        ";

        $results = $wpdb->get_results($sql); // execute sql query

        $pairs = array();

        foreach ($results as $row) {
            $pair = new Pair();
            $pair->id = $row->id;
            $pair->event = $row->event;
            $pair->guest1 = $row->guest1;
            $pair->guest2 = $row->guest2;
            $pair->cook = $row->cook;
            $pair->setCourse($row->course);

            $pairs[] = $pair;
        }


        return $pairs;

    }

    /**
     * Find a Pair in the Database through the id.
     *
     * @since   1.0.0
     * @param   int     $id     Pair ID
     * @return  Pair    $pair   Pair Object
     */
    static function findById($id) {

        global $wpdb;

        $table = self::TABLE_NAME;
        $databaseName =  DB_NAME;
        $prefix = $wpdb->prefix;

        // sql query find row with id
        $sql = "
            SELECT * FROM $databaseName.$prefix$table WHERE id='$id';
        ";

        $pair = new Pair();

        $row = $wpdb->get_row($sql); // execute sql query

        $pair->id = $row->id;
        $pair->event = $row->event;
        $pair->guest1 = $row->guest1;
        $pair->guest2 = $row->guest2;
        $pair->cook = $row->cook;
        $pair->setCourse($row->course);


        return $pair;
    }

    /**
     * Saves object in database table
     *
     * @since 1.0.0
     */
    public function save() {
        global $wpdb;

        // wp_kr_team
        $table_name = $wpdb->prefix . Database::DB_PAIR_NAME;

        $col = array(
            'event'     => $this->event,
            'course'    => $this->course,
            'cook'      => $this->cook,
            'guest1'    => $this->guest1,
            'guest2'    => $this->guest2,
        );

        // Format of each column (%s = String, %d = Number)
        $format = array(
            '%d',
            '%d',
            '%d',
            '%d',
            '%d',
        );

        if ($this->id !== NULL) { // is id already set
            $col['id'] = $this->id;
            $format[] = '%d';

            $wpdb->replace($table_name, $col, $format);

        } else {

            // save team in database
            $wpdb->insert(
                $table_name,
                $col,
                $format
            );
        }
    }



}