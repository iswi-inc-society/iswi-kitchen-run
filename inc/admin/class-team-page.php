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
class Team_Page extends Admin
{
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
     * Initialization Method that is called after the page is chosen.
     * Called by add_plugin_admin_menu() in Class Admin.
     *
     * @since 1.0.0
     */
    public function init() {

	    if (isset($_GET['event'])) { // get event by filter of table
		    $this->event = Event::findbyId($_GET['event']);
	    } else { // no filter -> current event for team table
		    $this->event = Event::findCurrent();
	    }

	    $output = '';

        if(isset($_GET['action'])) { // do several actions
            if ($_GET['action'] == 'delete') { // delete team
                $output .= $this->team_delete_page();
            } else if ($_GET['action'] == 'edit') { // edit team
	            $output .= $this->team_update_page('Update Kitchen Run Team', false);
            } else if ($_GET['action'] == 'add') { // add Team
	            $output .= $this->team_update_page('Add Kitchen Run Team', true);
            } else if ($_GET['action'] == 'pair') { // pair all teams for courses
	            $output .= $this->pair_teams();
            } else if ($_GET['action'] == 'unpair') { // unpair created pairs
	            $output .= $this->team_unpair_page();
            } else if ($_GET['action'] == 'info_mails') {
	            $output .= $this->information_mails();
            }
        } else if (isset($_POST['exg_pairs_submit'])) { // manually edit the created pairs
	        $output .= $this->exg_pairs();
        } else { // render event list table and pairs (if paired)
	        $output .= $this->team_list_table_page();
	        $output .= $this->team_pairs_page();
        }

        echo $output;

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

    	$teams_per_page = 10;

        $arguments = array(
            'label'		=>	__( 'Teams Per Page', $this->plugin_text_domain ),
            'default'	=>	$teams_per_page,
            'option'	=>	'teams_per_page'
        );
        add_screen_option( 'per_page', $arguments );

        //init for event list table
        $this->team_table = new Team_List_Table( $teams_per_page, $this->plugin_text_domain );
    }

    /**
     * Renders the Event List Table
     * Uses the WP_LIST_TABLE Class from Wordpress to create it.
     *
     * @since 1.0.0
     */
    public function team_list_table_page(){
        // query, filter, and sort the data
        $bool = $this->team_table->prepare_items();

        if ($bool) {
            // Render a template
            return $this->templates->render('html-team-list', [ // renders views/html-team-list.php
                'title' => __('Kitchen Run Teams', $this->plugin_text_domain),
                'table' => $this->team_table,
                'new'   => __('Add New', $this->plugin_text_domain),
            ]);
        } else {
        	Admin_Notice::create('info',  __('No Events yet registered!', $this->plugin_text_domain));
            return $this->templates->render('html-notices');
        }
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
        if(isset($_POST['team_submit']) && $this->verify_nonce('update_team', '_wpnonce_update_team', 'html-team-referer')) {

            // create team object with form data
	        if ($add) $team = new Team();
	        else $team = Team::findById($_POST['team_id']);

            $team->setName($_POST['team_name']);
            $team->setMember1($_POST['team_member_1']);
            $team->setMember2($_POST['team_member_2'] != '' ? $_POST['team_member_2'] : null);
            $team->setAddress($_POST['team_address']);
            $team->setCity($_POST['team_city']);
            $team->setPhone($_POST['team_phone']);
            $team->setEmail($_POST['team_email']);
            $team->setVegan(isset($_POST['team_vegan']) ? 1 : 0); // vegan checked?
            $team->setVegetarian(isset($_POST['team_vegetarian']) ? 1 : 0); // vegetarian checked?
            $team->setHalal(isset($_POST['team_halal']) ? 1 : 0); // halal checked?
            $team->setKosher(isset($_POST['team_kosher']) ? 1 : 0); // kosher checked?
            $team->setFoodRequest($_POST['team_food_request']);
            $team->setFindPlace($_POST['team_find_place']);
            $team->setAppetizer(isset($_POST['team_appetizer']) ? 1 : 0);
            $team->setMainCourse(isset($_POST['team_main_course']) ? 1 : 0);
            $team->setDessert(isset($_POST['team_dessert']) ? 1 : 0);
            $team->setComments($_POST['team_comment']);
            $team->setEvent(Event::findbyId($_POST['team_event']));
            $team->setValid(isset($_POST['team_valid']) ? 1 : 0);
            $team->setISWI(0); //TODO: ISWI Dummy Flag

            if (isset($_POST['team_link'])) { // can only be set when event is online
                $team->setLink();
            }
                
            $team->save();

            if ($add) Admin_Notice::create('success', sprintf(esc_html__('The Team %s was successfully created', $this->plugin_text_domain), $team->getName()));
            else Admin_Notice::create('success', sprintf(esc_html__('The Team %s was successfully updated', $this->plugin_text_domain), $team->getName()));
            return $this->templates->render('referer/html-team-referer'); // render views/html-team-referer.php

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

            return $this->templates->render('html-team-update-form', [ // render views/html-team-update-form.php
                'title'             => $title,
                'team'              => $team,
                'event_options'     => $options,
                'plugin_text_domain'=> $this->plugin_text_domain,
                'submit'            => $add ? __('Create Team', $this->plugin_text_domain) : __('Update Team', $this->plugin_text_domain),
            ]);
        }
    }

    /**
     * Renders the Page to confirm the team deletion process, submits this process and deletes the event.
     *
     * @since 1.0.0
     */
    public function team_delete_page() {

    	if (!$this->verify_nonce('delete_team')) die();

        if (isset($_POST['action']) && $this->verify_nonce('delete_team_confirmation', '_wpnonce_delete_team')) { // confirmation form submitted

            $team = Team::findbyId($_POST['team']);
            $team->delete();

            Admin_Notice::create('success', sprintf(esc_html__('The Team %s was successfully deleted', $this->plugin_text_domain), $team->getName()));
            return $this->templates->render('referer/html-team-referer'); // render views/html-team-referer.php

        } else { // delete confirmation form
            $team = Team::findbyId($_GET['team']); // needed in view

            return $this->templates->render('html-team-delete', [ // render views/html-team-delete.php
                'title'             => __('Delete Kitchen Run Team', $this->plugin_text_domain),
                'team'              => $team,
                'plugin_text_domain'=> $this->plugin_text_domain,
                'submit'            => __('Confirm Deletion', $this->plugin_text_domain),
            ]);
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
        if (isset($this->event) && $this->event instanceof Event && $this->event->getPaired()) { // only shown when teams of the event are paired
            $pairs = Pair::findByEvent($this->event); // needed in view

            return $this->templates->render('html-pair-table', [ // render views/html-pair-table.php
                'title'             => __('Team Pairs', $this->plugin_text_domain),
                'pairs'             => $pairs,
                'plugin_text_domain'=> $this->plugin_text_domain,
                'exchange'          => __('Exchange Pairs', $this->plugin_text_domain),
                'smails'            => __('Send Informations', $this->plugin_text_domain),
            ]);

        }
    }

    /**
     * Renders the Page to confirm the unpair process, submits this process and unpairs the teams.
     *
     * @since 1.0.0
     */
    private function team_unpair_page()
    {
        if (isset($_POST['action']) && $this->verify_nonce('unpair_event_confirmation', '_wpnonce_unpair_event')) { // confirmation form submitted

            $this->unpair_teams();

            return $this->templates->render('referer/html-team-referer'); // render views/html-team-referer.php

        } else { // unpair confirmation form

            return $this->templates->render('html-event-unpair', [ // render views/html-event-unpair.php
                'title'             => __('Unpair Teams', $this->plugin_text_domain),
                'event'             => $this->event,
                'plugin_text_domain'=> $this->plugin_text_domain,
                'submit'            => __('Confirm Unpairing', $this->plugin_text_domain),
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
        if(isset($_POST['exg_pairs_submit']) && $this->verify_nonce('exg_pairs', '_wpnonce_exg_pairs')) {

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

            Admin_Notice::create('success', sprintf(esc_html__('Teams were successfully exchanged', $this->plugin_text_domain)));
            return $this->templates->render('referer/html-team-referer');
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
        $teams = Team::findByEventAndValid($this->event);

        if (count($teams) < 7) {
	        Admin_Notice::create('error', sprintf(esc_html__('You need more than 7 teams to start the pair process. You only have %d valid Teams', $this->plugin_text_domain), count($teams)));
	        return $this->templates->render('referer/html-team-referer');

        } else {
            // How many dummy teams will be used
            $dummy_count = (count($teams) % 3) == 0 ? 0 : 3 - (count($teams) % 3);

            // add dummy teams
            for ($i=1; $i<=$dummy_count; $i++) {
                $team = new Team();
                $team->setName('Dummy Team '.$i);
                $team->setEvent($this->event);
                $team->setHalal(0);
                $team->setKosher(0);
                $team->setVegetarian(0);
                $team->setVegan(0);
                $team->setAppetizer(1);
                $team->setMainCourse(1);
                $team->setDessert(1);
                $team->setValid(true);
                $team->setISWI(true);
                $team->setToken(bin2hex(random_bytes(50)));
                $team->save();
                $teams[] = $team;

            }

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
            $g1 = $g2 = $g3 = array();
            foreach($candidates as $candidate) {
                switch($candidate['count']) {
                    case 1 :
                        $g1[] = $candidate;
                        break;
                    case 2 :
                        $g2[] = $candidate;
                        break;
                    case 3 :
                        $g3[] = $candidate;
                        break;
                    default :
                        trigger_error('Possible count > 3', E_USER_ERROR);
                }
            }
    

            /** @var int Number of Slots that are assigned for a course */
            $course1 = $course2 = $course3 = 0;
            $output = array();


            // Add single choices
            for ($i = 0; $i < count($g1); ++$i) {
                if ($g1[$i]['course1']) {
                    if ($course1 < $num_can / 3) { // course is full
	                    $output[0][$course1] = $g1[$i]['team'];
	                    $course1++;
                        continue;
                    }


                } elseif ($g1[$i]['course2']) {
                    if ($course2 < $num_can / 3) { // course is full
	                    $output[1][$course2] = $g1[$i]['team'];
	                    $course2++;
                        continue; 
                    }

                } elseif ($g1[$i]['course3']) {
                    if ($course3 < $num_can / 3) { // course is full
	                    $output[2][$course3] = $g1[$i]['team'];
	                    $course3++;
                        continue;
                    }

                }
	            $g2[] = $g1[$i]; // add the candidate in the next round
            }

            // Set two choices
            for ($i = 0; $i < count($g2); ++$i) {
                if ($g2[$i]['course1']) {
                    if ($course1 < $num_can / 3) {
                        $output[0][$course1] = $g2[$i]['team'];
                        $course1++;
                        continue;
                    }
                }
                if ($g2[$i]['course2']) {
                    if ($course2 < $num_can / 3) {
                        $output[1][$course2] = $g2[$i]['team'];
                        $course2++;
                        continue;
                    }
                }
                if ($g2[$i]['course3']) {
                    if ($course3 < $num_can / 3) {
                        $output[2][$course3] = $g2[$i]['team'];
                        $course3++;
                        continue;
                    }
                }

                // when course is full
                $g3[] = $g2[$i];
            }

            // Fill with three choices
            for ($i = 0; $i < count($g3); ++$i) {
                if ($course1 < $num_can / 3) {
                    $output[0][$course1] = $g3[$i]['team'];
                    $course1++;
                    continue;
                }
                if ($course2 < $num_can / 3) {
                    $output[1][$course2] = $g3[$i]['team'];
                    $associated[$i] = $g3[$i];
                    $course2++;
                    continue;
                }
                if ($course3 < $num_can / 3) {
                    $output[2][$course3] = $g3[$i]['team'];
                    $associated[$i] = $g3[$i];
                    $course3++;
                    continue;
                }
            }

            /** @var Pair[] $pairs */
            $pairs = array();

            $t_out = $output;


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

	        Admin_Notice::create('success', sprintf(esc_html__('The teams of the Event %s were successfully paired', $this->plugin_text_domain), $this->event->getName()));
	        return $this->templates->render('referer/html-team-referer');
        }
    }

    /**
     * Unpairs all Teams of an Event by deleting the pairs from the database.
     *
     * @since 1.0.0
     */
    private function unpair_teams()
    {
        if ($this->event->getPaired()) {
            $pairs = Pair::findByEvent($this->event);

            foreach ($pairs as $pair) $pair->delete();

            $this->event->setPaired(0);
            $this->event->save();

            Admin_Notice::create('success', sprintf(esc_html__( 'Successfully unpaired the Event %s', $this->plugin_text_domain ), $this->event->getName()));
        } else {
        	Admin_Notice::create('warning', sprintf(esc_html__( 'Event %s isn\'t paired.'  , $this->plugin_text_domain ), $this->event->getName()));
        }
    }

	/**
	 * Send the information mails
	 */
    private function information_mails() {

	    $teams = Team::findByEventAndValid($this->event);

	    $nonce_name = 'send_mails_confirmation';
	    $nonce_field = '_wpnonce_send_mails';

	    if (isset($_POST['action']) && $this->verify_nonce($nonce_name, $nonce_field)) { // confirmation form submitted

		    $error_msg = array();
		    $msg = array();
		    $errors = 0;

		    $course_length = 3600; // TODO: set in settings
		    $course_pause = 1800; // TODO: set in settings
		    $timestamp = $this->event->getEventDate()->getTimestamp();



		    // collect mails, but check for errors before sending all!
		    $teams_mail = array();
		    $i = 0;

		    // boolean to indicate a missing link
		    $missing_link = false;

		    if (!$this->event->getPaired()) { // check paired status
			    $errors++;
			    Admin_Notice::create('error', sprintf(esc_html__('Teams must be paired before sending emails.', $this->plugin_text_domain)));
		    } else {

			    foreach ( $teams as $team ) {
				    $pairs = Pair::findByEventAndTeam( $this->event, $team );

				    //course 1
				    $pair1  = $pairs[0];
				    $bcook1 = $pair1->getCook()->getId() == $team->getId();

				    //course 2
				    $pair2  = $pairs[1];
				    $bcook2 = $pair2->getCook()->getId() == $team->getId();

				    //course 3
				    $pair3  = $pairs[2];
				    $bcook3 = $pair3->getCook()->getId() == $team->getId();

				    // generate mail messages
				    $teams_mail[ $i ]['message'] = $this->templates->render( 'mail/html-pair-information-mail', [
					    'pair1'  => $pair1,
					    'bcook1' => $bcook1,
					    'pair2'  => $pair2,
					    'bcook2' => $bcook2,
					    'pair3'  => $pair3,
					    'bcook3' => $bcook3,
					    'team'   => $team,
					    'date'   => $this->event->getEventDate()->format( 'F jS, Y' ),
					    'stime1' => date( 'g.i a', $timestamp ),
					    'etime1' => date( 'g.i a', $timestamp + $course_length ),
					    'stime2' => date( 'g.i a', $timestamp + $course_length + $course_pause ),
					    'etime2' => date( 'g.i a', $timestamp + 2 * $course_length + $course_pause ),
					    'stime3' => date( 'g.i a', $timestamp + 2 * $course_length + 2 * $course_pause ),
					    'etime3' => date( 'g.i a', $timestamp + 3 * $course_length + 2 * $course_pause ),
				    ] );

				    $teams_mail[ $i ]['team']    = $team;
				    $teams_mail[ $i ++ ]['mail'] = $team->getEmail();

				    if ( $bcook1 + $bcook2 + $bcook3 != 1 ) {
					    ++ $errors; // check that team only cooks one time!
					    Admin_Notice::create('error', sprintf(esc_html__('Too many cooking courses for Team: Logic Error', $this->plugin_text_domain), $team->getName()));
				    }
			    }
		    }

		    if ($errors == 0) { // only send mails when everything went fine

			    $i = 0;

			    $subject = __('Kitchen Run Course Information', $this->plugin_text_domain);

			    $headers = array(
				    'Content-Type: text/html',
			    );

			    // Set Kitchen Run E-Mail Settings
			    $from_mail = get_option('kitchenrun_email');
			    $from_name = get_option('kitchenrun_email_name');
                $reply_to = get_option('kitchenrun_contact_email');
			    if (isset($from_mail) && isset($from_name))
				    $headers[] = 'From: '.$from_name.' <'.$from_mail.'>';
			    if (isset($from_mail))
				    $headers[] = 'From: '.$from_mail;
                if (isset($reply_to))
                    $headers[] = 'Reply-To: '.$reply_to;

			    foreach ($teams_mail as $mail) {

				    if (!wp_mail($mail['mail'], $subject, $mail['message'], $headers)){
					    Admin_Notice::create('error', sprintf(esc_html__('Mail couldn\'t be sent to %s', $this->plugin_text_domain), $mail['mail']));
					    $errors++;
				    }
			    }

			    if ($errors == 0) {
				    Admin_Notice::create('success', sprintf(esc_html__('All mails were successfully sent', $this->plugin_text_domain)));
			    }

		    }

		    return $this->templates->render('referer/html-team-referer');

	    } else { // confirmation form

	    	foreach($teams as $team) {
			    if ($team->getLink() == null) $missing_link = true;
		    }

		    if ($missing_link && $this->event->isOnline()) Admin_Notice::create('warning', esc_html__('Not every Team has a Meeting Link, so not every Session will get a Meeting Link!'));

		    return $this->templates->render('html-send-mails', [ // render views/html-team-delete.php
			    'title'                 => __('Send Course Information Mails', $this->plugin_text_domain),
			    'event'                 => $this->event,
			    'teams'                 => $teams,
			    'plugin_text_domain'    => $this->plugin_text_domain,
			    'submit'                => __('Send Mails', $this->plugin_text_domain),
			    'nonce_name'            => $nonce_name,
			    'nonce_field'           => $nonce_field
		    ]);
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
        return ($a_count < $b_count) ? -1 : 1;
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