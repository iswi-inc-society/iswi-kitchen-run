<?php


namespace KitchenRun\Inc\Frontend;


use KitchenRun\Inc\Common\Model\Event;
use KitchenRun\Inc\Common\Model\Team;
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

        if (isset($_POST['kr_team_submitted'])) { // form submitted

            $this->createTeam();

            $this->suc = 1;
        }
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
     * Creates a new team.
     *
     * Through the input from the form a new Team Object will be created and saved in the database.
     *
     * @since 1.0.0
     */
    private function createTeam()
    {

        // get all inputs from the form

        $this->team = new Team();
        $this->team->setName($_POST['kr_team_name']);
        $this->team->setMember1($_POST['kr_team_member_1']);
        $this->team->setMember2($_POST['kr_team_member_2'] != '' ? $_POST['kr_team_member_2'] : null);
        $this->team->setAddress($_POST['kr_team_address']);
        $this->team->setCity($_POST['kr_team_city']);
        $this->team->setPhone($_POST['kr_team_phone']);
        $this->team->setEmail($_POST['kr_team_email']);
        $this->team->setVegan(isset($_POST['kr_team_vegan']) ? 1 : 0); // vegan checked?
        $this->team->setVegetarian(isset($_POST['kr_team_vegetarian']) ? 1 : 0); // vegetarian checked?
        $this->team->setHalal(isset($_POST['kr_team_halal']) ? 1 : 0); // halal checked?
        $this->team->setKosher(isset($_POST['kr_team_kosher']) ? 1 : 0); // kosher checked?
        $this->team->setFoodRequest($_POST['kr_team_food_request']);
        $this->team->setFindPlace($_POST['kr_team_find_place']);
        $this->team->setAppetizer(isset($_POST['kr_team_appetizer']) ? 1 : 0);
        $this->team->setMainCourse(isset($_POST['kr_team_main_course']) ? 1 : 0);
        $this->team->setDessert(isset($_POST['kr_team_dessert']) ? 1 : 0);
        $this->team->setComments($_POST['kr_team_comment']);
        $this->team->setEvent(Event::findCurrent());
        $this->team->save();

        // send confirmation mail
        if ($this->confirmation_mail) {
            $this->sendConfirmationMail();
        }

        $this->suc = 1;
    }

    /**
     * Sends a Confirmation E-Mail to the registered Team with wp_mail.
     *
     * @since 1.0.0
     */
    public function sendConfirmationMail() {

        $to = $this->team->getName() . '<' . $this->team->getEmail() . '>'; //receiver
        $subject = __('Kitchen Run Team Registration', $this->plugin_text_domain);
        $message = $this->templates->render('mail/html-confirmation-mail', [
            'plugin_text_domain' => $this->plugin_text_domain,
        ]);
        $headers = array(
            'Content-Type: text/html',
            'Bcc: niklas.loos@iswi.org',
        );

        // Set Kitchen Run E-Mail Settings
        $from_mail = get_option('kitchenrun_email');
        $from_name = get_option('kitchenrun_email_name');
        if (isset($from_mail) && isset($from_name))
            $headers[] = 'From: '.$from_name.' <'.$from_mail.'>';
        else if (isset($from_mail))
            $headers[] = 'From: '.$from_mail;

        wp_mail($to, $subject, $message, $headers);
    }

    /**
     * Renders the sign up form through the html view.
     *
     * @since 1.0.0
     */
    public function render()
    {

        echo $this->templates->render('html-kitchenrun-signup', [ // render views/html-kitchenrun-signup.php
            'plugin_text_domain'    => $this->plugin_text_domain,
        ]);
    }
}