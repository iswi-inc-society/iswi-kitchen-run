<?php
namespace KitchenRun\Inc\Admin;

use KitchenRun\Inc\Common\Model\Event;
use KitchenRun\Inc\Common\Model\Pair;
use KitchenRun\Inc\Common\Model\Team;
use League\Plates\Engine;

/**
 * Class Team_Page
 * Processes all requests from the Teams submenu and Teams page.
 *
 * @author Niklas Loos <niklas.loos@live.com>
 * @package KitchenRun\Inc\Admin
 * @since 1.0.0
 */
class Team_Page
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
     * Event Object for updating or deleting events
     *
     * @since   1.0.0
     * @access  private
     * @var     Event   $event
     */
    private $event;

    /**
     * Event List Object to create the list of events
     *
     * @since   1.0.0
     * @access  private
     * @var     Team_List_Table $team_table
     */
    private $team_table;

    /**
     * Templating Engine Plates
     *
     * @since   1.0.0
     * @access  private
     * @var     Engine  $templates
     */
    private $templates;


    /**
     * Initialize the class and set its properties.
     *
     * @since       1.0.0
     * @param       string $plugin_name        The name of this plugin.
     * @param       string $version            The version of this plugin.
     * @param       string $plugin_text_domain The text domain of this plugin.
     */
    public function __construct( $plugin_name, $version, $plugin_text_domain ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->plugin_text_domain = $plugin_text_domain;

        $this->templates = new Engine(__DIR__ . '/views');

        if (isset($_GET['event'])) { // get event by filter of table
            $this->event = Event::findbyId($_GET['event']);
        } else { // no filter -> current event for team table
            $this->event = Event::findCurrent();
        }

    }

    /**
     * Initialization Method that is called after the page is chosen.
     * Called by add_plugin_admin_menu() in Class Admin.
     *
     * @since 1.0.0
     */
    public function init() {

        if(isset($_GET['action'])) { // do several actions
            if ($_GET['action'] == 'delete') { // delete team
                $this->team_delete_page();
            } else if ($_GET['action'] == 'edit') { // edit team
                $this->team_update_page('Update Kitchen Run Team', false);
            } else if ($_GET['action'] == 'add') { // add Team
                $this->team_update_page('Add Kitchen Run Team', true);
            } else if ($_GET['action'] == 'pair') { // pair all teams for courses
                $this->pair_teams();
            }
        } else if (isset($_POST['exg_pairs_submit'])) { // manually edit the created pairs
            $this->exg_pairs();
        } else { // render event list table and pairs (if paired)
            $this->team_list_table_page();
            $this->team_pairs_page();
        }


    }

    /**
     * Screen options for the List Table
     *
     * Callback for the load-($page_hook_suffix)
     * Called when the plugin page is loaded
     *
     * @since 1.0.0
     */
    public function load_team_list_table_screen_options() {
        $arguments = array(
            'label'		=>	__( 'Teams Per Page', $this->plugin_text_domain ),
            'default'	=>	5,
            'option'	=>	'teams_per_page'
        );
        add_screen_option( 'per_page', $arguments );

        //init for event list table
        $this->team_table = new Team_List_Table( $this->plugin_name, $this->version ,$this->plugin_text_domain );
    }

    /**
     * Renders the Event List Table
     * Uses the WP_LIST_TABLE Class from Wordpress to create it.
     *
     * @since 1.0.0
     */
    public function team_list_table_page(){
        // query, filter, and sort the data
        $this->team_table->prepare_items();

        // Render a template
        echo $this->templates->render('html-team-list', [ // renders views/html-team-list.php
            'title' => __('Kitchen Run Teams', $this->plugin_text_domain),
            'table' => $this->team_table,
            'new'   => __('Add New', $this->plugin_text_domain),
        ]);
    }

    /**
     * Renders the Team edit and add form and processes it.
     *
     * @param   string  $title     Title of the rendered page
     * @param   bool    $add       true: add new team; false: update existing team
     * @since   1.0.0
     */
    public function team_update_page($title, $add)
    {
        // form is submitted
        if(isset($_POST['team_submit'])) {
            if ( // check wpnonce -> to verify the validity of the form
                !isset($_POST['_wpnonce_update_team'])
                || !wp_verify_nonce($_POST['_wpnonce_update_team'], 'update_team')
            ) {

                print 'Sorry, your nonce did not verify.';
                exit;

            } else { // wpnonce successfully checked -> validated

                // create team object with form data
                $team = Team::findById($_POST['team_id']);
                $team->setName($_POST['team_name']);
                $team->setMember1($_POST['team_member_1']);
                $team->setMember2($_POST['team_member_2'] != '' ? $_POST['team_member_2'] : null);
                $team->setAddress($_POST['team_address']);
                $team->setCity($_POST['team_city']);
                $team->setPhone($_POST['team_phone']);
                $team->setEmail($_POST['team_email']);
                $team->setVegan(($_POST['team_food_preference'] == 'vegan') ? 1 : 0); // vegan checked?
                $team->setVegetarian(($_POST['team_food_preference'] == 'vegetarian') ? 1 : 0); // vegetarian checked?
                $team->setHalal(($_POST['team_food_preference'] == 'halal') ? 1 : 0); // halal checked?
                $team->setKosher(($_POST['team_food_preference'] == 'kosher') ? 1 : 0); // kosher checked?
                $team->setFoodRequest($_POST['team_food_request']);
                $team->setFindPlace($_POST['team_find_place']);
                $team->setAppetizer(isset($_POST['team_appetizer']) ? 1 : 0);
                $team->setMainCourse(isset($_POST['team_main_course']) ? 1 : 0);
                $team->setDessert(isset($_POST['team_dessert']) ? 1 : 0);
                $team->setComments($_POST['team_comment']);
                $team->setEvent(Event::findbyId($_POST['team_event']));
                $team->save();

                echo $this->templates->render('html-team-referer'); // render views/html-team-referer.php
            }
        } else { // render form
            if ($add) $team = new Team();
            else $team = Team::findbyId($_GET['team']); // needed in view

            // Event Options
            $options = array();

            foreach (Event::findAll() as $event) {
                $current = !$add ? $team->getEvent()->getId() == $event->getId() : false;
                $options[] = sprintf('<option value="%s" %s>%s</option>',
                    $event->getId(),
                    ($current) || $event->getId() == Event::findCurrent()->getId() ? 'selected' : '',
                    $event->getName());
            }

            echo $this->templates->render('html-team-update-form', [ // render views/html-team-update-form.php
                'title'             => $title,
                'team'              => $team,
                'event_options'     => $options,
                'plugin_text_domain'=> $this->plugin_text_domain,
                'submit'            => $add ? __('Create Team', $this->plugin_text_domain) : __('Update Team', $this->plugin_text_domain),
            ]);
        }
    }

    /**
     * Renders the Page to confirm the event deletion process, submits this process and deletes the event.
     *
     * @since 1.0.0
     */
    public function team_delete_page() {
        if ( // check wpnonce -> to verify the validity of the form
            ! isset( $_GET['_wpnonce'] )
            || ! wp_verify_nonce( $_GET['_wpnonce'], 'delete_team' )
        ) {

            print 'Sorry, your nonce did not verify.';
            exit;

        } else { // wpnonce successfully checked

            if (isset($_POST['action'])) { // confirmation form submitted

                if ( // check wpnonce for confirmation -> to verify the validity of the form
                    ! isset( $_POST['_wpnonce_delete_team'] )
                    || ! wp_verify_nonce( $_POST['_wpnonce_delete_team'], 'delete_team_confirmation' )
                ) {

                    print 'Sorry, your nonce did not verify.';
                    exit;

                } else { // wpnonce for confirmation successfully checked
                    $event = Team::findbyId($_POST['team']);
                    $event->delete();

                    echo $this->templates->render('html-team-referer'); // render views/html-team-referer.php
                }
            } else { // delete confirmation form
                $team = Team::findbyId($_GET['team']); // needed in view

                echo $this->templates->render('html-team-delete', [ // render views/html-team-delete.php
                    'title'             => __('Delete Kitchen Run Team', $this->plugin_text_domain),
                    'team'              => $team,
                    'plugin_text_domain'=> $this->plugin_text_domain,
                    'submit'            => __('Confirm Deletion', $this->plugin_text_domain),
                ]);
            }
        }
    }

    /**
     * Renders a table with the pairs for each course.
     * In the table the user can exchange guest pairs to edit the outcome of the algorithm.
     *
     * @since 1.0.0
     */
    public function team_pairs_page()
    {
        if ($this->event->getPaired()) { // only shown when teams of the event are paired
            $pairs = Pair::findByEvent($this->event); // needed in view

            echo $this->templates->render('html-pair-table', [ // render views/html-pair-table.php
                'title'             => __('Team Pairs', $this->plugin_text_domain),
                'pairs'             => $pairs,
                'plugin_text_domain'=> $this->plugin_text_domain,
                'exchange'          => __('Exchange Pairs', $this->plugin_text_domain),
            ]);

        }
    }

    /**
     * Algorithm to exchange to guest pairs from the same course.
     *
     * @since 1.0.0
     */
    public function exg_pairs()
    {
        // form is submitted
        if(isset($_POST['exg_pairs_submit'])) {
            if ( // check wpnonce -> to verify the validity of the form
                !isset($_POST['_wpnonce_exg_pairs'])
                || !wp_verify_nonce($_POST['_wpnonce_exg_pairs'], 'exg_pairs')
            ) {

                print 'Sorry, your nonce did not verify.';
                exit;

            } else { // wpnonce successfully checked

                $exg1 = $_POST['guest_exg_1'];
                $exg2 = $_POST['guest_exg_2'];

                // pair 1
                $id1 = substr($exg1, strpos($exg1,'-')+1);
                $pair1 = Pair::findById($id1);
                $guest1 = substr($exg1, strpos($exg1,'-')-1,1);

                // pair 2
                $id2 = substr($exg2, strpos($exg2,'-')+1);
                $pair2 = Pair::findById($id2);
                $guest2 = substr($exg2, strpos($exg2,'-')-1,1);


                if ($pair1->getId() === $pair2->getId()) { // same pairs
                    $tmp = $pair1->getGuest1();
                    $pair1->setGuest1($pair1->getGuest2());
                    $pair1->setGuest2($tmp);

                    $pair1->save(); // save in db

                } else { // different pairs
                    // go through all possibilities and exchange
                    if ($guest1 == 1) { // guest 1 of pair 1
                        $tmp = $pair1->getGuest1();
                        $pair1->setGuest1($guest2 == 1 ? $pair2->getGuest1() : $pair2->getGuest2());
                    } else { // guest 2 of pair 2
                        $tmp = $pair1->getGuest2();
                        $pair1->setGuest2($guest2 == 1 ? $pair2->getGuest1() : $pair2->getGuest2());
                    }
                    if ($guest2 == 1) { // guest 1 of pair 2
                        $pair2->setGuest1($tmp);
                    } else { // guest 2 of pair 2
                        $pair2->setGuest2($tmp);
                    }

                    // save in db
                    $pair1->save();
                    $pair2->save();
                }

                include_once('views/html-team-referer.php'); // refer back to team table
            }
        }
    }


    /**
     * Algorithm to create the team pairs for each course. Still based on the old algorithm.
     *
     * @since 1.0.0
     *
     * @var Team[] $teams
     *
     * @TODO create new algorithm that has a whitelist/blacklist
     */
    public function pair_teams() {

        /** @var Team[] $teams */
        $teams = Team::findByEvent($this->event);

        if (count($teams) < 7) {
            echo 'You need more than 7 teams to start the pair process';

        } else {
            // How many dummy teams will be used
            $dummy_count = 3 - (count($teams) % 3);

            // add dummy teams
            for ($i=1; $i<=$dummy_count; $i++) {
                $team = new Team();
                $team->setName('Dummy Team '.$i);
                $team->setEvent($this->event);
                $team->setAppetizer(1);
                $team->setMainCourse(1);
                $team->setDessert(1);
                $team->save();

            }

            /** @var Team[] $teams */
            $teams = Team::findByEvent($this->event);

            // Randomize team order
            shuffle($teams);

            // Build preferences array
            $candidates = array();
            foreach($teams as $team) {
                $candidates[] = array(
                    'team'		=> $team,
                    'course1'	=> (bool) $team->getAppetizer(),
                    'course2'	=> (bool) $team->getMainCourse(),
                    'course3'	=> (bool) $team->getDessert(),
                    'count'		=> (int) $team->getAppetizer() + (int) $team->getMainCourse() + (int) $team->getDessert()
                );
            }
            $num_can = count($candidates);
            $groups = count($candidates) / 3;

            // Sort array by preferences count ascending
            usort($candidates, array($this, "cmp"));

            // Count possibilities
            $n1 = $n2 = $n3 = 0;
            foreach($candidates as $candidate) {
                switch($candidate['count']) {
                    case 1 :
                        ++$n1;
                        break;
                    case 2 :
                        ++$n2;
                        break;
                    case 3 :
                        ++$n3;
                        break;
                    default :
                        trigger_error('Possible count > 3', E_USER_ERROR);
                }
            }

            $course1 = $course2 = $course3 = 0;
            $output = $associated = array();


            // Add single choices
            for ($i = 0; $i < $n1; ++$i) {
                if ($candidates[$i]['course1']) {
                    $output[$course1][0] = $candidates[$i]['team'];
                    $associated[$i] = $candidates[$i];
                    unset($candidates[$i]);
                    $course1++;
                } elseif ($candidates[$i]['course2']) {
                    $output[$course2][1] = $candidates[$i]['team'];
                    $associated[$i] = $candidates[$i];
                    unset($candidates[$i]);
                    $course2++;
                } elseif ($candidates[$i]['course3']) {
                    $output[$course3][2] = $candidates[$i]['team'];
                    $associated[$i] = $candidates[$i];
                    unset($candidates[$i]);
                    $course3++;
                }
            }

            // Set two choices
            for (; $i < ($n1 + $n2); ++$i) {
                if ($candidates[$i]['course1']) {
                    if ($course1 < $num_can / 3) {
                        $output[$course1][0] = $candidates[$i]['team'];
                        $associated[$i] = $candidates[$i];
                        unset($candidates[$i]);
                        $course1++;
                        continue;
                    }
                }
                if ($candidates[$i]['course2']) {
                    if ($course2 < $num_can / 3) {
                        $output[$course2][1] = $candidates[$i]['team'];
                        $associated[$i] = $candidates[$i];
                        unset($candidates[$i]);
                        $course2++;
                        continue;
                    }
                }
                if ($candidates[$i]['course3']) {
                    if ($course3 < $num_can / 3) {
                        $output[$course3][2] = $candidates[$i]['team'];
                        $associated[$i] = $candidates[$i];
                        unset($candidates[$i]);
                        $course3++;
                        continue;
                    }
                }
            }

            // Fill with three choices
            for (; $i < count($candidates); ++$i) {
                if ($course1 < $num_can / 3) {
                    $output[$course1][0] = $candidates[$i]['team'];
                    $associated[$i] = $candidates[$i];
                    unset($candidates[$i]);
                    $course1++;
                    continue;
                }
                if ($course2 < $num_can / 3) {
                    $output[$course2][1] = $candidates[$i]['team'];
                    $associated[$i] = $candidates[$i];
                    unset($candidates[$i]);
                    $course2++;
                    continue;
                }
                if ($course3 < $num_can / 3) {
                    $output[$course3][2] = $candidates[$i]['team'];
                    $associated[$i] = $candidates[$i];
                    unset($candidates[$i]);
                    $course3++;
                    continue;
                }
            }


            // Fill up missing
            foreach($candidates as $team) {
                if ($course1 < $num_can / 3) {
                    $output[$course1][0] = $team['team'];
                    unset($candidates[$i]);
                    $course1++;
                    continue;
                }
                if ($course2 < $num_can / 3) {
                    $output[$course2][1] = $team['team'];
                    unset($candidates[$i]);
                    $course2++;
                    continue;
                }
                if ($course3 < $num_can / 3) {
                    $output[$course3][2] = $team['team'];
                    unset($candidates[$i]);
                    $course3++;
                    continue;
                }
            }
            foreach($output as &$row) {
                ksort($row);
            }
            /** @var Pair[] $pairs */
            $pairs = array();
            $t_out = $this->_transpose($output);


            // Calculate team partners
            foreach($t_out as $course => $team) {

                switch ($course) {
                    case 0 :
                        for ($i = 0; $i < $groups; ++$i) {
                            $pair = new Pair();
                            $pair->setEvent($this->event);
                            $pair->setCook($team[$i]);
                            $pair->setCourse(0);
                            $pair->setGuest1($t_out[$course+1][$i]);
                            $pair->setGuest2($t_out[$course+2][$i]);
                            $pairs[] = $pair;
                        }
                        break;
                    case 1 :
                        for ($i = 0; $i < $groups; ++$i) {
                            $pair = new Pair();
                            $pair->setEvent($this->event);
                            $pair->setCourse(1);
                            $pair->setCook($team[$i]);
                            $pair->setGuest1(($i+1 < $groups) ? $t_out[$course-1][$i+1] : $t_out[$course-1][$i-$groups+1]);
                            $pair->setGuest2(($i+2 < $groups) ? $t_out[$course+1][$i+2] : $t_out[$course+1][$i-$groups+2]);
                            $pairs[] = $pair;
                        }
                        break;
                    case 2 :
                        for ($i = 0; $i < $groups; ++$i) {
                            $pair = new Pair();
                            $pair->setEvent($this->event);
                            $pair->setCourse(2);
                            $pair->setCook($team[$i]);
                            $pair->setGuest1(($i+1 < $groups) ? $t_out[$course-2][$i+1] : $t_out[$course-2][$i-$groups+1]);
                            $pair->setGuest2(($i+2 < $groups) ? $t_out[$course-1][$i+2] : $t_out[$course-1][$i-$groups+2]);
                            $pairs[] = $pair;
                        }
                        break;
                    default :
                        trigger_error('Invalid course.', E_USER_ERROR);
                        die();
                }
            }

            foreach($pairs as $pair) { // save all in db
                $pair->save();
            }

            $this->event->setPaired(1); // event now paired status
            $this->event->save();
        }
    }

    /**
     * Compare function for php usort function.
     * To compare two $candidate arrays for their number of preferred courses.
     *
     * @param   array   $candidate1     Candidate Array -> see pair_teams()
     * @param   array   $candidate2     Candidate Array -> see pair_teams()
     * @return  int
     */
    protected function cmp($candidate1, $candidate2) {
        $a_count = $candidate1['count'];
        $b_count = $candidate2['count'];

        if ($a_count == $b_count) {
            return 0;
        }
        return ($a_count < $b_count) ? +1 : -1;
    }

    /**
     * Transpose a matrix (array)
     *
     * @param $matrix
     * @return mixed
     */
    protected function _transpose($matrix) {
        array_unshift($matrix, null);
        return call_user_func_array('array_map', $matrix);
    }
}