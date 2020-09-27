<?php

namespace KitchenRun\Inc\Common\Model;


use DateTime;
use Exception;
use WP_User as WP_User;

/**
 * Class Event
 * Model of a Event that is saved in the Database or newly created.
 *
 * @since       1.0.0
 * @package     KitchenRun\Inc\Common\Model
 * @author      Niklas Loos <niklas.loos@live.com>
 */
class Event
{

    /**
     * Format that is uses for dates in the Database.
     *
     * @since   1.0.0
     * @var     string  DATE_FORMAT
     */
    const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * ID of the Event. Autogenerated by the DB.
     *
     * @since   1.0.0
     * @access  private
     * @var     int $id
     */
    private $id;

    /**
     * Name of the Event.
     *
     * @since   1.0.0
     * @access  private
     * @var     string $name
     */
    private $name;

    /**
     * Is it the current Event.
     * '0' -> not current
     * '1' -> current
     *
     * @since   1.0.0
     * @access  private
     * @var     int $current
     */
    private $current;

    /**
     * Date on which the signup form will be opened.
     * Format: See DATE_FORMAT.
     *
     * @since   1.0.0
     * @access  private
     * @var     string $opening_date
     */
    private $opening_date;

    /**
     * Date on which the signup form will be closed.
     * Format: See DATE_FORMAT.
     *
     * @since   1.0.0
     * @access  private
     * @var     string $closing_date
     */
    private $closing_date;

    /**
     * Date on which the event will take place.
     * Format: See DATE_FORMAT.
     *
     * @since   1.0.0
     * @access  private
     * @var     string $event_date
     */
    private $event_date;

    /**
     * Wordpress User ID of the manager of the event.
     * Normally the User who created the event.
     *
     * @since   1.0.0
     * @access  private
     * @var     int $manager
     */
    private $manager;

    /**
     * Are the Event Teams already paired?
     * '0' -> no
     * '1' -> yes
     *
     * @since   1.0.0
     * @access  private
     * @var     int $paired
     */
    private $paired;


    /**
     * Get Event ID.
     *
     * @since   1.0.0
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Event Name.
     *
     * @since   1.0.0
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Event Name
     *
     * @since   1.0.0
     * @param   string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Is this the current Event?
     * '0' -> no
     * '1' -> yes
     *
     * @since   1.0.0
     * @return  int
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * Set whether this is the current event.
     * '0' -> not current
     * '1' -> current
     *
     * @since   1.0.0
     * @param   int $current
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    }

    /**
     * Get the Opening Date for the sign up.
     *
     * @since   1.0.0
     * @return  DateTime|null   NULL shouldn't be reached!
     */
    public function getOpeningDate()
    {
        try {
            return new DateTime($this->opening_date);
        } catch (Exception $e) {
            return NULL;
        }
    }

    /**
     * Set Opening Date for the sign up. String should be in the DATE_FORMAT.
     *
     * @since   1.0.0
     * @param   DateTime|string $opening_date
     */
    public function setOpeningDate($opening_date)
    {
        if ($opening_date instanceof DateTime) {
            $this->opening_date = $opening_date->format(self::DATE_FORMAT);
        } else {
            $this->opening_date = $opening_date;
        }
    }

    /**
     * Get the Closing Date for the sign up.
     *
     * @since   1.0.0
     * @return  DateTime|null   NULL shouldn't be reached!
     */
    public function getClosingDate()
    {

        try {
            return new DateTime($this->closing_date);
        } catch (Exception $e) {
            return NULL;
        }
    }

    /**
     * Set Closing Date for the sign up. String should be in the DATE_FORMAT.
     *
     * @since   1.0.0
     * @param   DateTime|string $closing_date
     */
    public function setClosingDate($closing_date)
    {
        if ($closing_date instanceof DateTime) {
            $this->closing_date = $closing_date->format(self::DATE_FORMAT);
        } else {
            $this->closing_date = $closing_date;
        }
    }

    /**
     * Get the Date of the event.
     *
     * @since   1.0.0
     * @return  DateTime|null   NULL shouldn't be reached!
     */
    public function getEventDate()
    {
        try {
            return new DateTime($this->event_date);
        } catch (Exception $e) {
            return NULL;
        }
    }

    /**
     * Set Event Date. String should be in the DATE_FORMAT.
     *
     * @since   1.0.0
     * @param   DateTime|string $event_date
     */
    public function setEventDate($event_date)
    {
        if ($event_date instanceof DateTime) {
            $this->event_date = $event_date->format(self::DATE_FORMAT);
        } else {
            $this->event_date = $event_date;
        }
    }

    /**
     * Get Manager of the Event as Wordpress User.
     *
     * @return  WP_User
     *@since   1.0.0
     */
    public function getManager()
    {
        /** @var WP_User $userdata */
        $userdata = WP_User::get_data_by( 'ID', $this->manager );

        return $userdata;
    }

    /**
     * Set Manager of the Event, should be Wordpress User.
     *
     * @param   WP_User $manager
     * @since   1.0.0
     */
    public function setManager($manager)
    {
        $this->manager = $manager->ID;
    }

    /**
     * Are the Teams of the Event already paired.
     * '0' -> no
     * '1' -> yes
     *
     * @since   1.0.0
     * @return  int
     */
    public function getPaired() {
        return $this->paired;
    }

    /**
     * Set the Pair Status of the Event.
     * '0' -> not paired
     * '1' -> paired
     *
     * @since   1.0.0
     * @param   int $bool
     */
    public function setPaired($bool) {
        $this->paired = $bool;
    }


    /**
     * Find a Event in the Database through the id.
     *
     * @since   1.0.0
     * @param   int     $id     Event ID
     * @return  Event   $event  Event Object
     */
    public static function findbyId($id)
    {
        $db = new Database();

        $result = $db->findBy(Database::DB_EVENT_NAME, 'id', $id, true);

        $event = Event::resultToObject($result);

        return $event;
    }

    /**
     * Find the Current Event in Database.
     *
     * @since   1.0.0
     * @return  Event   $event  Event Object
     */
    public static function findCurrent() {
        $db = new Database();

        $result = $db->findBy(Database::DB_EVENT_NAME, 'current', 1, true);

        $event = NULL;
        if (isset($result)) {
            $event = Event::resultToObject($result);
        }

        return $event;
    }

    /**
     * Find all Events saved in the Database and save them in an Event Array.
     *
     * @since   1.0.0
     * @return  Event[] $event  Array of Event Object
     */
    public static function findAll() {
        $db = new Database();

        $results = $db->findAll(Database::DB_EVENT_NAME);

        $events = array();

        // create each event object
        if (isset($results)) {
            foreach ($results as $row) {
                $events[] = Event::resultToObject($row);
            }
        }   

        return $events;
    }

    /**
     * Saves object in database table
     *
     * @since 1.0.0
     */
    public function save() {

        $db = new Database();

        $row = array( //convert event object to row array for database
            'name' => $this->name,
            'event_date' => $this->event_date,
            'opening_date' => $this->opening_date,
            'closing_date' => $this->closing_date,
            'manager' => $this->manager,
            'current' => $this->current,
            'paired' => $this->paired,
        );

        // Format of each column (%s = String, %d = Number)
        $format = array(
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
            '%d',
            '%d',
        );

        $db->saveRow(Database::DB_EVENT_NAME, $row, $format, $this->id);

    }

    /**
     * Deletes object from database.
     *
     * @since 1.0.0
     */
    public function delete()
    {
        // delete pairs of event
        $pairs = Pair::findByEvent($this);
        foreach ($pairs as $pair) $pair->delete();

        // delete teams of event
        $teams = Team::findByEvent($this);
        foreach ($teams as $team) $team->delete();

        $db = new Database();
        $db->deleteRow(Database::DB_EVENT_NAME, $this->id);
    }

    /**
     * Creates a Event Object through a database row object. The row object is created through the Database class.
     *
     * @since   1.0.0
     * @param   object  $row    Row Object from Database
     * @return  Event   $event  Event Object
     */
    private static function resultToObject($row) {

        /** @var WP_User $wp_user */
        $wp_user = WP_User::get_data_by( 'ID', $row->manager );

        $event = new Event();
        $event->id = $row->id;
        $event->setName($row->name);
        $event->setCurrent($row->current);
        $event->setOpeningDate($row->opening_date);
        $event->setClosingDate($row->closing_date);
        $event->setEventDate($row->event_date);
        $event->setManager($wp_user);
        $event->setPaired($row->paired);

        return $event;
    }

}