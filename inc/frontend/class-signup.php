<?php


namespace KitchenRun\Inc\Frontend;


use KitchenRun\Inc\Common\Model\Event;
use KitchenRun\Inc\Common\Model\Team;
use DateTime;
use League\Plates\Engine;

/**
 * Class Signup
 * Processes and renders the sign up form for the wordpress frontend.
 *
 * @author Niklas Loos <niklas.loos@live.com>
 * @package KitchenRun\Inc\Frontend
 * @since 1.0.0
 */
class Signup
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
     * Templating Engine Plates
     *
     * @since   1.0.0
     * @access  private
     * @var     Engine  $templates
     */
    private $templates;

    /**
     * Team that is signing up
     *
     * @since   1.0.0
     * @access  private
     * @var     Team    $team   Team Object
     */
    private $team;

    /**
     * was sign up successful?
     * '0' -> unsuccessful
     * '1' -> successful
     *
     * @since   1.0.0
     * @access  private
     * @var     boolean $suc    Success of the Sign Up
     */
    private $suc = 0;

    /**
     * Should a confirmation email be sent after registration.
     *
     * @since   1.0.0
     * @access  private
     * @var     bool
     */
    private $confirmation_mail;

    private $error_msg = array();

    // States
    const NO_EVENT = 'NO_EVENT';
    const SUCCESS = 'SUCCESS';
    const BEFORE_SIGNUP = 'BEFORE_SIGNUP';
    const SIGNUP = 'SIGNUP';
    const AFTER_SIGNUP = 'AFTER_SIGNUP';
    const AFTER_EVENT = 'AFTER_EVENT';
    const VALIDATION = 'VALIDATION';
    const SUBMIT = 'SUBMIT';
 
    /**
     * Signup constructor.
     *
     * Checks the state of sign up (submitted or not)
     *
     * @since 1.0.0
     * @param       string $plugin_name        The name of this plugin.
     * @param       string $version            The version of this plugin.
     * @param       string $plugin_text_domain The text domain of this plugin.
     * @param       bool   $confirmation_mail  Should a confirmation mail be sent after registration?
     */
    public function __construct( $plugin_name, $version, $plugin_text_domain, $confirmation_mail )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->plugin_text_domain = $plugin_text_domain;

        $this->confirmation_mail = $confirmation_mail;

        $this->templates = new Engine(__DIR__ . '/views');
    }

    public function init() {


        $state = $this->getState();
        $message = '';

        if (isset($_POST['kr_team_submitted'])) {
            if ($this->submit()){
                return $this->templates->render('html-kitchenrun-success-referer');
            }
        }

        //no current event
        if ($state == self::NO_EVENT) {
            $message = __('There is no upcoming Kitchen Run Event yet.',$this->plugin_text_domain);
        } else {

            // variables needed for messages
            $event = $this->getEvent();
            $opening_date = $event->getOpeningDate();
            $closing_date = $event->getClosingDate();
            $event_date = $event->getEventDate();

            // get the right message through state
            switch($state) {
                case self::SUCCESS:
                    $message = __('Your Sign Up was successful. Please verify your email. We send you some instruction per email. For questions, please contact ',
                    $this->plugin_text_domain).get_option('kitchenrun_contact_email');
                break;

                case self::VALIDATION:
                    $message = $this->verifyToken($_GET['token']);
                break;

                case self::BEFORE_SIGNUP:
                    $message = __('The next Kitchen Run Event will be on the '.
                    $event_date->format('d.m.Y').'. If you are interested, the sign up starts on the '.
                    $opening_date->format('d.m.Y').'.',
                    $this->plugin_text_domain);
                break;

                case self::SIGNUP:
                    $message = __('The next Kitchen Run Event will be on the '.
                    $event_date->format('d.m.Y').'. The Sign Up stays open until the '.
                    $closing_date->format('d.m.Y').'.',
                    $this->plugin_text_domain);
                break;

                case self::AFTER_SIGNUP:
                    $message = __('The next Kitchen Run Event will be on the '.
                    $event_date->format('d.m.Y').'. The Sign Up is closed but, if you have questions contact kitchenrun@iswi.org',
                    $this->plugin_text_domain);
                break;

                case self::AFTER_EVENT:
                    $message = __('There is no upcoming Kitchen Run Event. The last Event was on the '.
                    $event_date->format('d.m.Y').'. If you are interested in another Event, contact kitchenrun@iswi.org',
                    $this->plugin_text_domain);
                break;

                default:
                    $message = __('There is no upcoming Kitchen Run Event yet.',$this->plugin_text_domain);
                break;
            }
        }

        return $this->templates->render('html-kitchenrun-info', [ // render views/html-kitchenrun-info.php
                'errors'   =>   $this->error_msg,
                'message'  =>   $message,
                'state'    =>   $state,
                'signup'   =>   $this,
	            'team'     =>   $this->team,
        ]);
    }

    public function getState() {

        if ($this->getEvent() == null) {
            return self::NO_EVENT;
        }

        if (isset($_GET['success'])) {
            return self::SUCCESS;
        }

        if (isset($_GET['token'])) {
            return self::VALIDATION;
        }

        $event = $this->getEvent();
        $opening_date = $event->getOpeningDate()->getTimestamp();
        $closing_date = $event->getClosingDate()->getTimestamp();
        $event_date = $event->getEventDate()->getTimestamp();
        $current_date = time();

        if ($current_date > $event_date) {
            return self::AFTER_EVENT;
        }

        if ($current_date > $closing_date) {
            return self::AFTER_SIGNUP;
        }

        if ($current_date > $opening_date) {
            return self::SIGNUP;
        }

        return self::BEFORE_SIGNUP;

    }

    /**
     * Get the Kitchen Run Event for that the Team is signing up
     *
     * @since   1.0.0
     * @return  Event
     */
    public function getEvent() {
        return Event::findCurrent();
    }

    /**
     * Was the sign up successful? Important for success message.
     * '0' -> unsuccessful
     * '1' -> successful
     *
     * @return bool|int
     */
    public function isSuccessful() {
        return $this->suc;
    }


	/**
	 * Check Form Input and create new team entry.
	 *
	 * @return bool
	 * @throws \Exception
	 */
    public function submit() {
        $errors = 0;
        $err_msg = array();

        $this->team = new Team();

        $name = trim($_POST["kr_team_name"]);
        $member1 = trim($_POST["kr_team_member_1"]);
        $member2 = trim($_POST["kr_team_member_2"]);
        $address = trim($_POST["kr_team_address"]);
        $city = trim($_POST["kr_team_city"]);
        $phone = trim($_POST["kr_team_phone"]);
        $email = trim($_POST["kr_team_email"]);
        $vegan = isset($_POST['kr_team_vegan']) ? true : false;
        $vegetarian = isset($_POST['kr_team_vegetarian']) ? true : false;
        $halal = isset($_POST['kr_team_halal']) ? true : false;
        $kosher = isset($_POST['kr_team_kosher']) ? true : false;
        $food_request = trim($_POST['kr_team_food_request']);
        $find_place = trim($_POST['kr_team_find_place']);
        $appetizer = isset($_POST['kr_team_appetizer']) ? true : false;
        $main_course = isset($_POST['kr_team_main_course']) ? true : false;
        $dessert = isset($_POST['kr_team_dessert']) ? true : false;
        $comments = trim($_POST['kr_team_comment']);
        $event = Event::findCurrent();
        
        // check if email is already used
        $team = Team::findByMailAndEvent($email, $event);
        if (isset($team)) {
            $this->error_msg[] = 'E-Mail Address is already used, please choose another one!';
            $errors++;
        }

        // check if at least on course is choosen
        if ($appetizer + $main_course + $dessert == 0) {
        	$this->error_msg[] = 'Please choose at lest one course!';
        	$errors++;
        }

        if ($errors == 0) {
            $this->team->setName($name);
            $this->team->setMember1($member1);
            $this->team->setMember2($member2 != '' ? $member2 : null);
            $this->team->setAddress($address);
            $this->team->setCity($city);
            $this->team->setPhone($phone);
            $this->team->setEmail($email);
            $this->team->setVegan($vegan); // vegan checked?
            $this->team->setVegetarian($vegetarian); // vegetarian checked?
            $this->team->setHalal($halal); // halal checked?
            $this->team->setKosher($kosher); // kosher checked?
            $this->team->setFoodRequest($food_request);
            $this->team->setFindPlace($find_place);
            $this->team->setAppetizer($appetizer);
            $this->team->setMainCourse($main_course);
            $this->team->setDessert($dessert);
            $this->team->setComments($comments);
            $this->team->setEvent($event);
            $this->team->setValid(false);
            $this->team->setToken(bin2hex(random_bytes(50)));
            $this->team->setISWI(false);
            $this->team->save();

            $this->sendConfirmationMail();

            return true;
        } else {
            return false;
        }

    }

	/**
	 * Verify Email Address by Token and generate Response Message
	 *
	 * @param $token
	 *
	 * @return string|void
	 */
    public function verifyToken($token) {
    	$team = Team::findByToken($token);

    	if (isset($team) && $team->getEvent()->getCurrent()) {
			if ($team->getValid()) return __('Your Team ').$team->getName().__(' is already valid.');
			else {
				$team->setValid(true);
				$team->save();
				return __('Your Team ').$team->getName().__(' is now validated and you will get first information soon.');
			}
	    } else return __('There is no Team linked to your token.');
    }

    /**
     * Sends a Confirmation E-Mail to the registered Team with wp_mail.
     *
     * @since 1.0.0
     */
    public function sendConfirmationMail() {

        $to = $this->team->getName() . '<' . $this->team->getEmail() . '>'; //receiver
        $subject = __('Kitchen Run Team Registration', $this->plugin_text_domain);

        // create courses string for email
        $courses = '';
	    if ($this->team->getAppetizer()) $courses .= 'appetizer, ';
        if ($this->team->getMainCourse()) $courses .= 'main course, ';
	    if ($this->team->getDessert()) $courses .= 'dessert, ';
	    if ($courses == 'appetizer, main course, dessert, ') $courses = 'All';
	    else $food_preferences = substr($courses, 0, strlen($courses)-2); // delete , from the string

	    // create courses string for email
	    $food_preferences = '';
	    if ($this->team->getVegan()) $food_preferences .= 'vegan, ';
	    if ($this->team->getVegetarian()) $food_preferences .= 'vegetarian, ';
	    if ($this->team->getHalal()) $food_preferences .= 'halal, ';
	    if ($this->team->getKosher()) $food_preferences .= 'kosher, ';
	    if ($food_preferences == '') $food_preferences = 'Everything';
	    else $food_preferences = substr($food_preferences, 0, strlen($food_preferences)-2); // delete , from the string

	    $params = array_merge( $_GET, array( 'token' => $this->team->getToken() ) );
	    $new_query_string = http_build_query( $params );
	    $defaultHost = 'localhost';
	    $verifyLink = ( empty( $_SERVER['HTTPS'] ) ? 'http://' : 'https://' ) .
	                  ( empty( $_SERVER['HTTP_HOST'] ) ? $defaultHost : $_SERVER['HTTP_HOST'] ) .
	                  $_SERVER['REQUEST_URI'] . '?' . $new_query_string;


        $message = $this->templates->render('mail/html-confirmation-mail', [
            'plugin_text_domain' => $this->plugin_text_domain,
            'date' => $this->team->getEvent()->getEventDate()->format('d.m.Y'),
            'time' => $this->team->getEvent()->getEventDate()->format('h:i'),
            'food_preferences' => $food_preferences,
            'courses' => $courses,
            'team' => $this->team,
	        'verifyLink' => $verifyLink,
        ]);
        $headers = array(
            'Content-Type: text/html',
        );

        // Set Kitchen Run E-Mail Settings
        $from_mail = get_option('kitchenrun_email');
        $from_name = get_option('kitchenrun_email_name');
        if (isset($from_mail) && isset($from_name))
            $headers[] = 'From: '.$from_name.' <'.$from_mail.'>';
        else if (isset($from_mail))
            $headers[] = 'From: '.$from_mail;

        return wp_mail($to, $subject, $message, $headers);
    }

    /**
     * Renders the sign up form through the html view.
     *
     * @since 1.0.0
     */
    public function render()
    {

        echo $this->templates->render('html-kitchenrun-signup-multiform', [ // render views/html-kitchenrun-signup.php
            'plugin_text_domain'    => $this->plugin_text_domain,
        ]);
    }
}