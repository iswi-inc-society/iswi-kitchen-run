<?php


namespace KitchenRun\Inc\Frontend;


use KitchenRun\Inc\Common\Model\Event;
use KitchenRun\Inc\Common\Model\Team;

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
     * Signup constructor.
     *
     * Checks the state of sign up (submitted or not)
     *
     * @since 1.0.0
     */
    public function __construct()
    {
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
    public function isSuccessfull() {
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
        $this->team->setKosher(isset($_POST['kr_team_kosher']) ? 1 : 0); // kosha checked?
        $this->team->setFoodRequest($_POST['kr_team_food_request']);
        $this->team->setFindPlace($_POST['kr_team_find_place']);
        $this->team->setAppetizer(isset($_POST['kr_team_appetizer']) ? 1 : 0);
        $this->team->setMainCourse(isset($_POST['kr_team_main_course']) ? 1 : 0);
        $this->team->setDessert(isset($_POST['kr_team_dessert']) ? 1 : 0);
        $this->team->setComments($_POST['kr_team_comment']);
        $this->team->setEvent(Event::findCurrent());
        $this->team->save();

        $this->suc = 1;
    }

    /**
     * Renders the sign up form through the html view.
     *
     * @since 1.0.0
     */
    public function render()
    {
        include_once('views/html-kitchenrun-signup.php');
    }
}