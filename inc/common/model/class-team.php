<?php


namespace KitchenRun\Inc\Common\Model;

/**
 * Class Team
 *
 * Model of a Team that is saved in the Database or newly created. A Team are one or two people who cook or are guests
 * in a course during the Kitchen Run Event.
 *
 * @since       1.0.0
 * @package     KitchenRun\Inc\Common\Model
 * @author      Niklas Loos <niklas.loos@live.com>
 */
class Team
{
    /**
     * Name of the Database Table that is used to save the teams.
     *
     * @since   1.0.0
     * @var     string  TABLE_NAME
     */
    const TABLE_NAME = "kr_team";

    /**
     * ID of the Team. Autogenerated by the DB.
     *
     * @since   1.0.0
     * @access  private
     * @var     int $id
     */
    private $id;

    /**
     * ID of the Event in which the team is participating.
     *
     * @since   1.0.0
     * @access  private
     * @var     int $event
     */
    private $event;

    /**
     * Name of the Team. Can be everything :D
     *
     * @since   1.0.0
     * @access  private
     * @var     string  $name
     */
    private $name;

    /**
     * Name of the first participant in the team. Is mandatory for a team.
     *
     * @since   1.0.0
     * @access  private
     * @var     string  $member1
     */
    private $member1 = "";

    /**
     * Name of the second participant in the team. Is optional for a team.
     *
     * @since   1.0.0
     * @access  private
     * @var     string  $member2
     */
    private $member2 = "";

    /**
     * E-Mail of the Team. All Important Information are send to this mail.
     *
     * @since   1.0.0
     * @access  private
     * @var     string  $email
     */
    private $email = "";

    /**
     * Address where the team is cooking one of the courses.
     *
     * @since   1.0.0
     * @access  private
     * @var     string  $address
     */
    private $address = "";

    /**
     * City of the address. Normally Ilmenau.
     *
     * @since   1.0.0
     * @access  private
     * @var     string  $city
     */
    private $city = "";

    /**
     * Phone Number on which the team is always reachable. For really important and fast information.
     *
     * @since   1.0.0
     * @access  private
     * @var     string  $phone
     */
    private $phone = "";

    /**
     * One of the Food Preferences of the Team.
     * If one or both of the participants is vegan. Either as information for the pairing process or as information
     * for the cooking team.
     * '0' -> not vegan
     * '1' -> vegan
     *
     * @since   1.0.0
     * @access  private
     * @var     int $vegan
     */
    private $vegan;

    /**
     * One of the Food Preferences of the Team.
     * If one or both of the participants is vegetarian. Either as information for the pairing process or as information
     * for the cooking team.
     * '0' -> not vegetarian
     * '1' -> vegetarian
     *
     * @since   1.0.0
     * @access  private
     * @var     int $vegetarian
     */
    private $vegetarian;

    /**
     * One of the Food Preferences of the Team.
     * If one or both of the participants is eating halal. Either as information for the pairing process or as information
     * for the cooking team.
     * '0' -> not halal
     * '1' -> halal
     *
     * @since   1.0.0
     * @access  private
     * @var     int $halal
     */
    private $halal;

    /**
     * One of the Food Preferences of the Team.
     * If one or both of the participants is eating kosher. Either as information for the pairing process or as information
     * for the cooking team.
     * '0' -> not kosher
     * '1' -> kosher
     *
     * @since   1.0.0
     * @access  private
     * @var     int $kosher
     */
    private $kosher;

    /**
     * General comment of the team for what food they don't want or want to eat. Also important for allergies.
     * This Information will be send to the cooking team.
     *
     * @since   1.0.0
     * @access  private
     * @var     string  $food_request
     */
    private $food_request = "";

    /**
     * General comment of the team on where to find their apartment or home.
     * This Information will be send to the guest teams.
     *
     * @since   1.0.0
     * @access  private
     * @var     string  $find_place
     */
    private $find_place = "";

    /**
     * General comment of the event or god and the world :D
     *
     * @since   1.0.0
     * @access  private
     * @var     string  $comments
     */
    private $comments = "";

    /**
     * One of the Course Preferences of the Team.
     * If the team doesn't really want to cook the appetizer. Just a preference, doesn't mean they don't have to.
     * '0' -> prefer not to cook the appetizer
     * '1' -> would cook appetizer
     *
     * @since   1.0.0
     * @access  private
     * @var     int $appetizer
     */
    private $appetizer;

    /**
     * One of the Course Preferences of the Team.
     * If the team doesn't really want to cook the main course. Just a preference, doesn't mean they don't have to.
     * '0' -> prefer not to cook the main course
     * '1' -> would cook main course
     *
     * @since   1.0.0
     * @access  private
     * @var     int $main_course
     */
    private $main_course;

    /**
     * One of the Course Preferences of the Team.
     * If the team doesn't really want to cook the dessert. Just a preference, doesn't mean they don't have to.
     * '0' -> prefer not to cook the dessert
     * '1' -> would cook dessert
     *
     * @since   1.0.0
     * @access  private
     * @var     int $dessert
     */
    private $dessert;

    /**
     * E-Mail validation flag
     * 
     * @since   1.0.0
     * @access  private
     * @var     int $valid
     */
    private $valid;

    /**
     * token used for e-mail validation
     * 
     * @since   1.0.0
     * @access  private
     * @var     string $valid
     */
    private $token;

    /**
     * ISWI/Dummy Team flag
     *
     * @var     int $valid
     */
    private $iswi = 0;

	/**
	 * Meeting Link
	 *
	 * @var string $link
	 */
    private $link;

	/**
	 * Sharing of Photos
	 *
	 * @var bool $photos
	 */
	private $photos;


    /**
     * Get Team ID.
     *
     * @since   1.0.0
     * @return  int
     */
    public function getId(){ return $this->id; }

    /**
     * Get the Event in which the team is participating.
     *
     * @since   1.0.0
     * @return  Event   Event Object of the participating Event
     */
    public function getEvent() {
        return isset($this->event) ? Event::findbyId($this->event) : null;
    }

    /**
     * Set the Event in which the team is participating.
     *
     * @since   1.0.0
     * @access  private
     * @param   Event   $event  Event Object of the participating Event
     */
    public function setEvent($event) {
        if ($event instanceof Event) {
            $this->event = $event->getId();
        }
    }

    /**
     * Get the Name of the Team.
     *
     * @since   1.0.0
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the Name of the Team.
     *
     * @since   1.0.0
     * @param   string  $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the Name of the first participant in the team.
     *
     * @since   1.0.0
     * @return  string
     */
    public function getMember1()
    {
        return $this->member1;
    }

    /**
     * Set the Name of the first participant in the team.
     *
     * @since   1.0.0
     * @param   string  $member1
     */
    public function setMember1($member1)
    {
        $this->member1 = $member1;
    }

    /**
     * Get the Name of the second participant in the team. Could be an empty string, then there is only one member.
     *
     * @since   1.0.0
     * @return  string
     */
    public function getMember2()
    {
        return $this->member2;
    }

    /**
     * Set the Name of the second participant in the team. Is optional.
     *
     * @since   1.0.0
     * @param   string  $member2
     */
    public function setMember2($member2)
    {
        $this->member2 = $member2;
    }

    /**
     * Get the E-Mail of the Team. All Important Information are send to this mail.
     *
     * @since   1.0.0
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the E-Mail of the Team. All Important Information are send to this mail.
     *
     * @since   1.0.0
     * @param   string  $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get the Address where the team is cooking one of the courses.
     *
     * @since   1.0.0
     * @return  string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the Address where the team is cooking one of the courses.
     *
     * @since   1.0.0
     * @param   string  $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get City of the address. Normally Ilmenau.
     *
     * @since   1.0.0
     * @return  string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set City of the address. Normally Ilmenau.
     *
     * @since   1.0.0
     * @param   string  $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get the Phone Number on which the team is always reachable. For really important and fast information.
     *
     * @since   1.0.0
     * @return  string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the Phone Number on which the team is always reachable. For really important and fast information.
     *
     * @since   1.0.0
     * @param   string  $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get One of the Food Preferences of the Team.
     * If one or both of the participants is vegan. Either as information for the pairing process or as information
     * for the cooking team.
     * '0' -> not vegan
     * '1' -> vegan
     *
     * @since   1.0.0
     * @return  int
     */
    public function getVegan()
    {
        return $this->vegan;
    }

    /**
     * Set One of the Food Preferences of the Team.
     * If one or both of the participants is vegan. Either as information for the pairing process or as information
     * for the cooking team.
     * '0' -> not vegan
     * '1' -> vegan
     *
     * @since   1.0.0
     * @param   int $vegan
     */
    public function setVegan($vegan)
    {
        $this->vegan = $vegan;
    }

    /**
     * Get One of the Food Preferences of the Team.
     * If one or both of the participants is vegetarian. Either as information for the pairing process or as information
     * for the cooking team.
     * '0' -> not vegetarian
     * '1' -> vegetarian
     *
     * @since   1.0.0
     * @return  int
     */
    public function getVegetarian()
    {
        return $this->vegetarian;
    }

    /**
     * Set One of the Food Preferences of the Team.
     * If one or both of the participants is vegetarian. Either as information for the pairing process or as information
     * for the cooking team.
     * '0' -> not vegetarian
     * '1' -> vegetarian
     *
     * @since   1.0.0
     * @param   int $vegetarian
     */
    public function setVegetarian($vegetarian)
    {
        $this->vegetarian = $vegetarian;
    }

    /**
     * Get One of the Food Preferences of the Team.
     * If one or both of the participants is eating halal. Either as information for the pairing process or as information
     * for the cooking team.
     * '0' -> not eating halal
     * '1' -> eating halal
     *
     * @since   1.0.0
     * @return  int
     */
    public function getHalal()
    {
        return $this->halal;
    }

    /**
     * Set One of the Food Preferences of the Team.
     * If one or both of the participants is eating halal. Either as information for the pairing process or as information
     * for the cooking team.
     * '0' -> not eating halal
     * '1' -> eating halal
     *
     * @since   1.0.0
     * @param   int $halal
     */
    public function setHalal($halal)
    {
        $this->halal = $halal;
    }

    /**
     * Get One of the Food Preferences of the Team.
     * If one or both of the participants is eating kosher. Either as information for the pairing process or as information
     * for the cooking team.
     * '0' -> not eating kosher
     * '1' -> eating kosher
     *
     * @since   1.0.0
     * @return  int
     */
    public function getKosher()
    {
        return $this->kosher;
    }

    /**
     * Set One of the Food Preferences of the Team.
     * If one or both of the participants is eating kosher. Either as information for the pairing process or as information
     * for the cooking team.
     * '0' -> not eating kosher
     * '1' -> eating kosher
     *
     * @since   1.0.0
     * @param   int $kosher
     */
    public function setKosher($kosher)
    {
        $this->kosher = $kosher;
    }

    /**
     * Get the General comment of the team for what food they don't want or want to eat. Also important for allergies.
     * This Information will be send to the cooking team.
     *
     * @since   1.0.0
     * @return  string
     */
    public function getFoodRequest()
    {
        return $this->food_request;
    }

    /**
     * Set the General comment of the team for what food they don't want or want to eat. Also important for allergies.
     * This Information will be send to the cooking team.
     *
     * @since   1.0.0
     * @param   string  $food_request
     */
    public function setFoodRequest($food_request)
    {
        $this->food_request = $food_request;
    }

    /**
     * Get the General comment of the team on where to find their apartment or home.
     * This Information will be send to the guest teams.
     *
     * @since   1.0.0
     * @return  string
     */
    public function getFindPlace()
    {
        return $this->find_place;
    }

    /**
     * Set the General comment of the team on where to find their apartment or home.
     * This Information will be send to the guest teams.
     *
     * @since   1.0.0
     * @param   string  $find_place
     */
    public function setFindPlace($find_place)
    {
        $this->find_place = $find_place;
    }

    /**
     * Get the General comment of the event or god and the world :D
     *
     * @since   1.0.0
     * @return  string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set the General comment of the event or god and the world :D
     *
     * @since   1.0.0
     * @param   string  $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * Get one of the Course Preferences of the Team.
     * If the team doesn't really want to cook the appetizer. Just a preference, doesn't mean they don't have to.
     * '0' -> prefer not to cook the appetizer
     * '1' -> would cook appetizer
     *
     * @since   1.0.0
     * @return  int
     */
    public function getAppetizer()
    {
        return $this->appetizer;
    }

    /**
     * Set one of the Course Preferences of the Team.
     * If the team doesn't really want to cook the appetizer. Just a preference, doesn't mean they don't have to.
     * '0' -> prefer not to cook the appetizer
     * '1' -> would cook appetizer
     *
     * @since   1.0.0
     * @param   int $appetizer
     */
    public function setAppetizer($appetizer)
    {
        $this->appetizer = $appetizer;
    }

    /**
     * Get one of the Course Preferences of the Team.
     * If the team doesn't really want to cook the main course. Just a preference, doesn't mean they don't have to.
     * '0' -> prefer not to cook the main course
     * '1' -> would cook main course
     *
     * @since   1.0.0
     * @return  int
     */
    public function getMainCourse()
    {
        return $this->main_course;
    }

    /**
     * Set one of the Course Preferences of the Team.
     * If the team doesn't really want to cook the main course. Just a preference, doesn't mean they don't have to.
     * '0' -> prefer not to cook the main course
     * '1' -> would cook main course
     *
     * @since   1.0.0
     * @param   int $main_course
     */
    public function setMainCourse($main_course)
    {
        $this->main_course = $main_course;
    }

    /**
     * Get one of the Course Preferences of the Team.
     * If the team doesn't really want to cook the dessert. Just a preference, doesn't mean they don't have to.
     * '0' -> prefer not to cook the dessert
     * '1' -> would cook dessert
     *
     * @since   1.0.0
     * @return  int
     */
    public function getDessert()
    {
        return $this->dessert;
    }

    /**
     * Set one of the Course Preferences of the Team.
     * If the team doesn't really want to cook the dessert. Just a preference, doesn't mean they don't have to.
     * '0' -> prefer not to cook the dessert
     * '1' -> would cook dessert
     *
     * @since   1.0.0
     * @param   int $dessert
     */
    public function setDessert($dessert)
    {
        $this->dessert = $dessert;
    }

    /**
     * Get valid flag.
     *
     * @since   1.0.0
     * @return   int
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Set valid flag.
     *
     * @since   1.0.0
     * @param   int $valid
     */
    public function setValid($valid) {
        $this->valid = $valid;
    }

    /**
     * Get token for email validation
     *
     * @since   1.0.0
     * @return   string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * set token for email validation
     *
     * @since   1.0.0
     * @param   int $token
     */
    public function setToken($token) {
        $this->token = $token;
    }

    /**
     * Get ISWI flag.
     *
     * @since   1.0.0
     * @return   int
     */
    public function getISWI()
    {
        return $this->iswi;
    }

    /**
     * Set ISWI flag.
     *
     * @since   1.0.0
     * @param   int $iswi
     */
    public function setISWI($iswi) {
        $this->iswi = $iswi;
    }

    public function setLink($link) {
    	$this->link = $link;
    }

    public function getLink() {
    	return $this->link;
    }

	public function setPhotosAgreement($agreedToPhotos) {
		$this->photos = $agreedToPhotos;
	}

	public function agreedToPhotos() {
		return $this->photos;
	}

    /**
     * Find a Team in the Database through the id.
     *
     * @since   1.0.0
     * @param   int     $id     Team ID
     * @return  Team    $team   Team Object
     */
    static function findById($id) {
        $db = new Database();

        $result = $db->findBy(Database::DB_TEAM_NAME, 'id', $id, true);

        $team = Team::resultToObject($result);

        return $team;
    }


    /**
     * Find a Team in the Database by token.
     *
     * @since   1.0.0
     * @param   string  $token  Team Token
     * @return  Team    $team   Team Object
     */
    static function findByToken($token) {
        $db = new Database();

        $result = $db->findBy(Database::DB_TEAM_NAME, 'token', $token, true);

	    if (isset($result)) {
		    $team = Team::resultToObject( $result );
		    return $team;
	    } else return NULL;


    }

    /**
     * Find a list of Teams in the Database through the event, where they participate.
     *
     * @since   1.0.0
     * @param   Event   $event  Event Object
     * @return  Team[]  $teams  Array of Team Objects
     */
    static function findByEvent($event) {

        if (isset($event)) {
            $event_id = $event->getId();
        } else {
            return NULL;
        }

        $db = new Database();

        $results = $db->findBy(Database::DB_TEAM_NAME, 'event', $event_id, false);

        $teams = array();

        if (isset($results)) {
            foreach ($results as $result) {
                $teams[] = Team::resultToObject($result);
            }
        }

        return $teams;
    }

	/**
	 * Find a list of Teams in the Database through the event, where they participate.
	 *
	 * @since   1.0.0
	 * @param   Event   $event  Event Object
	 * @return  Team[]  $teams  Array of Team Objects
	 */
	static function findByEventAndValid($event) {

		if (isset($event)) {
			$event_id = $event->getId();
		} else {
			return NULL;
		}

		$db = new Database();

		$results = $db->findBy(Database::DB_TEAM_NAME, 'event', $event_id, false);

		$teams = array();

		if (isset($results)) {
			foreach ($results as $result) {
				if ($result->valid) {
					$teams[] = Team::resultToObject( $result );
				}
			}
		}

		return $teams;
	}

    static function findByMailAndEvent($mail, $event) {

        if (isset($event)) {
            $event_id = $event->getId();
        } else {
            return NULL;
        }

        $db = new Database();

        $results = $db->findBy(Database::DB_TEAM_NAME, 'event', $event_id, false);

        $teams = array();

        if (isset($results)) {
            foreach ($results as $result) {
                /** @var Team */
                $team = Team::resultToObject($result);

                if ($mail == $team->getEmail()) return $team;
            }
        }

        return NULL;
    }



    /**
     * Find all teams in database and save them in a list.
     *
     * @return Team[]   $teams  Array of Team Objects
     */
    static function findAll() {

        $db = new Database();

        $results = $db->findAll(Database::DB_TEAM_NAME);

        $teams = array();

        // create each team object
        foreach ($results as $row) {
            $teams[] = Team::resultToObject($row);
        }

        return $teams;
    }

    /**
     * Saves object in database table
     *
     * @since 1.0.0
     */
    public function save() {

        $db = new Database();

        $row = array(
            'name' => $this->getName(),
            'member1' => $this->getMember1(),
            'member2' => $this->getMember2(),
            'address' => $this->getAddress(),
            'city' => $this->getCity(),
            'telephone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'vegan' => $this->getVegan(),
            'vegetarian' => $this->getVegetarian(),
            'halal' => $this->getHalal(),
            'kosher' => $this->getKosher(),
            'food_requests' => $this->getFoodRequest(),
            'find_place' => $this->getFindPlace(),
            'appetizer' => $this->getAppetizer(),
            'main_course' => $this->getMainCourse(),
            'dessert' => $this->getDessert(),
            'comments' => $this->getComments(),
            'event' => $this->event,
            'valid' => $this->getValid(),
            'token' => $this->getToken(),
            'iswi'  => $this->getISWI(),
	        'link'  => $this->getLink(),
	        'photo_agreement' => $this->agreedToPhotos(),
        );

        // Format of each column (%s = String, %d = Number)
        $format = array(
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
            '%d',
            '%d',
            '%d',
            '%s',
            '%s',
            '%d',
            '%d',
            '%d',
            '%s',
            '%d',
            '%d',
            '%s',
            '%d',
	        '%s',
	        '%d',
        );


        // insert into db and save new id in id field
        $this->id = $db->saveRow(Database::DB_TEAM_NAME, $row, $format, $this->id);

    }

    /**
     * Deletes object from database.
     *
     * @since 1.0.0
     */
    public function delete()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . Database::DB_TEAM_NAME;

        $wpdb->delete( $table_name, array( 'id' => $this->id ) );
    }

    /**
     * Creates a Team Object through a database row object. The row object is created through the Database class.
     *
     * @since   1.0.0
     * @param   object  $row    Row Object from Database
     * @return  Team    $team   Team Object
     */
    private static function resultToObject($row) {

        $team = new Team();
        $team->id = $row->id;
        $team->setName($row->name);
        $team->setMember1($row->member1);
        $team->setMember2($row->member2);
        $team->setAddress($row->address);
        $team->setCity($row->city);
        $team->setPhone($row->telephone);
        $team->setEmail($row->email);
        $team->setVegan($row->vegan);
        $team->setVegetarian($row->vegetarian);
        $team->setHalal($row->halal);
        $team->setKosher($row->kosher);
        $team->setFoodRequest($row->food_requests);
        $team->setFindPlace($row->find_place);
        $team->setAppetizer($row->appetizer);
        $team->setMainCourse($row->main_course);
        $team->setDessert($row->dessert);
        $team->setComments($row->comments);
        $team->event = $row->event;
        $team->setValid($row->valid);
        $team->setToken($row->token);
        $team->setISWI($row->iswi);
        $team->setLink($row->link);
		$team->setPhotosAgreement($row->photo_agreement);

        return $team;
    }
}