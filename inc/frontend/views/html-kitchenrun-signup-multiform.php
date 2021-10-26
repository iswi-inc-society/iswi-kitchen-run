<?php
use League\Plates\Template\Template;

/**
 * View to render the team sign up form.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var     Template    $this                   Template Object to render
 * @var     string      $plugin_text_domain     Translation Domain
 * @var     string      $state                  state of form
 * @var     string      $opening_date           Opening Date String
 * @var     string      $closing_date           Closing Date String
 * @var     string      $event_date             Event Date String
 * @var     array       $errors                 Errors
 */

?>

<?php $this->insert('html-kitchenrun-signup-info', [
	'plugin_text_domain' => $plugin_text_domain,
	'state'         => $state,
	'opening_date'  => $opening_date,
	'closing_date'  => $closing_date,
	'event_date'    => $event_date
]);
?>

<div class="kr_container">

    <ul class="kr_progressbar">
        <li>Team</li>
        <li>Contact</li>
        <li>Address</li>
        <li>Food</li>
        <!-- <li>Courses</li> -->
        <li>Submit</li>
    </ul>

	<?php if (isset($errors)): ?>
		<?php foreach ($errors as $error): ?>
            <div class="kr_error_msg">
				<?= $error ?>
            </div>
		<?php endforeach ?>
	<?php endif; ?>

    <form id="kr_signup" class="kr_signup" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">

        <fieldset id="kr_tab_1" class="kr_tab">
            <h4 class="kr_step_subtitle">Team Information</h4>
            <p class="kr_step_description">Please choose a Team Name and tell us your names. One team member is at least required.</p>

            <div class="kr_txtb">
                <input type="text" id="kr_team_name" name="kr_team_name" value="<?php if (isset($_POST['kr_team_name'])) echo $_POST['kr_team_name'] ?>" required>
                <span data-placeholder="Team Name"></span>
            </div>

            <div class="kr_txtb">
                <input type="text" name="kr_team_member_1" value="<?php if (isset($_POST['kr_team_member_1'])) echo $_POST['kr_team_member_1'] ?>" required>
                <span data-placeholder="Team Member 1"></span>
            </div>

            <div class="kr_txtb">
                <input type="text" name="kr_team_member_2" value="<?php if (isset($_POST['kr_team_member_2'])) echo $_POST['kr_team_member_2'] ?>">
                <span data-placeholder="Team Member 2"></span>
            </div>

            <input type="button" name="kr_next" class="kr_btn_next" value="Next" />

        </fieldset>

        <fieldset id="kr_tab_2" class="kr_tab">
            <h4 class="kr_step_subtitle">Contact Information</h4>
            <p class="kr_step_description">The E-Mail Address is needed to send your team the information for the evening. At the end of the sign up you need to confirm your E-Mail Address.</p>

            <div class="kr_txtb">
                <input type="email" name="kr_team_email" value="<?php if (isset($_POST['kr_team_email'])) echo $_POST['kr_team_email'] ?>" required>
                <span data-placeholder="E-Mail"></span>
            </div>

            <div class="kr_txtb">
                <input type="tel" name="kr_team_phone" value="<?php if (isset($_POST['kr_team_phone'])) echo $_POST['kr_team_phone'] ?>" required>
                <span data-placeholder="Phone Number"></span>
            </div>

            <input type="button" name="kr_prev" class="kr_btn_prev" value="Previous" />

            <input type="button" name="kr_next" class="kr_btn_next" value="Next" />

        </fieldset>


        <fieldset id="kr_tab_3" class="kr_tab">
            <h4 class="kr_step_subtitle">Address Information</h4>
            <p class="kr_step_description">Your address is needed so that your guests can find you. The description is only needed when your home is not so easy to find.</p>

            <div class="kr_txtb">
                <input type="text" name="kr_team_address" value="<?php if (isset($_POST['kr_team_address'])) echo $_POST['kr_team_address'] ?>" required>
                <span data-placeholder="Address"></span>
            </div>

            <div class="kr_txtb">
                <input type="text" name="kr_team_city" value="<?php if (isset($_POST['kr_team_city'])) echo $_POST['kr_team_city'] ?>" required>
                <span data-placeholder="City"></span>
            </div>

            <div class="kr_txtb">
                <textarea name="kr_team_find_place"><?php if (isset($_POST['kr_team_find_place'])) echo $_POST['kr_team_find_place'] ?></textarea>
                <span data-placeholder="Description to find my place (if it is difficult to find)"></span>
            </div>


            <input type="button" name="kr_prev" class="kr_btn_prev" value="Previous" />

            <input type="button" name="kr_next" class="kr_btn_next" value="Next" />

        </fieldset>

        <fieldset id="kr_tab_4" class="kr_tab">
            <h4 class="kr_step_subtitle">Food Preferences</h4>
            <p class="kr_step_description">Please tell us your food preferences, multiple selections are possible. Please use the text field, if you have allergies or something else. The information will be sent to the cooking team.</p>

            <!-- just needed for verification -->
            <input type="hidden" name="food_pref" id="kr_food_pref">

            <div class="kr_chbox">
                <input type="checkbox" name="kr_team_vegan" id="kr_vegan" class="kr_food" <?php if (isset($_POST['kr_team_vegan'])) echo "checked" ?>>
                <label for="kr_vegan">Vegan</label>
            </div>

            <div class="kr_chbox">
                <input type="checkbox" name="kr_team_vegetarian" id="kr_veggie" class="kr_food" <?php if (isset($_POST['kr_team_vegetarian'])) echo "checked" ?>>
                <label for="kr_veggie">Vegetarian</label>
            </div>

            <div class="kr_chbox">
                <input type="checkbox" name="kr_team_halal" id="kr_halal" class="kr_food" <?php if (isset($_POST['kr_team_halal'])) echo "checked" ?>>
                <label for="kr_halal">Halal</label>
            </div>

            <div class="kr_chbox">
                <input type="checkbox" name="kr_team_kosher" id="kr_kosher" class="kr_food" <?php if (isset($_POST['kr_team_kosher'])) echo "checked" ?>>
                <label for="kr_kosher">Kosher</label>
            </div>

            <div class="kr_chbox">
                <input type="checkbox" name="kr_team_everything" id="kr_all" class="kr_food" <?php if (isset($_POST['kr_team_everything'])) echo "checked" ?>>
                <label for="kr_all">I eat everything!</label>
            </div>

            <div class="kr_txtb">
                <textarea class="team_food_request" name="kr_team_food_request"><?php if (isset($_POST['kr_team_food_request'])) echo $_POST['kr_team_food_request'] ?></textarea>
                <span data-placeholder="Allergies, Food Requests, ..."></span>
            </div>

            <input type="button" name="kr_prev" class="kr_btn_prev" value="Previous" />

            <input type="button" name="kr_next" class="kr_btn_next" value="Next" />

        </fieldset>

        <fieldset id="kr_tab_5" class="kr_tab">
            <h4 class="kr_step_subtitle">Submit</h4>
            <p class="kr_step_description">It is time to submit your kitchen run registration. You will get an verification E-Mail after that!</p>

            <div class="kr_txtb">
                <textarea name="kr_team_comment"><?php if (isset($_POST['kr_team_comment'])) echo $_POST['kr_team_comment'] ?></textarea>
                <span data-placeholder="Place for some general comments"></span>
            </div>

            <div class="kr_acord">
                <div class="kr_acord_label"><span class="dashicons dashicons-arrow-right"></span>Privacy Agreement</div>
                <div class="kr_acord_text kr_priv_aggreement">
                    <h4>Einwilligungserklärung in die Verarbeitung personenbezogener Daten gemäß DSGVO</h4>

                    <p>Hiermit stimme ich der folgenden Verarbeitung meiner personenbezogenen Daten durch den ISWI e.V. zu:</p>

                    <h5>Kategorie und Art der Datenverarbeitung</h5>

                    <p>Folgende personenbezogene Daten werden durch den ISWI e.V. verarbeitet:</p>

                    <ul>
                        <li>Name, Vorname</li>
                        <li>Adresse</li>
                        <li>E-Mail-Adresse</li>
                        <li>ggf. Allergien und Ernährungspräferenz</li>
                    </ul>

                    <p>Die Verarbeitung der personenbezogenen Daten durch den ISWI e.V. umfasst:</p>

                    <ul>
                        <li>Datenerhebung</li>
                        <li>Datenspeicherung</li>
                        <li>Weitergabe der zur Durchführung des "Kitchen Run"</li>
                    </ul>

                    <h5>Besondere Kategorien personenbezogener Daten</h5>

                    <p>Folgende besondere personenbezogene Daten werden durch den ISWI e.V. verarbeitet:</p>

                    <ul><li>Gesundheitsdaten (Allergien)</li></ul>

                    <h5>Zweck der Datenverarbeitung</h5>

                    <p>Diese Daten werden nur zu folgenden Zweck(en) verarbeitet:</p>

                    <ul><li>Durchfürung der Veranstaltung "kitchen-run"</li></ul>

                    <h5>Datensicherheit</h5>

                    <p>Diese Daten werden nur von berechtigten Personen unter Einhaltung einer angemessenen Datensicherheit bearbeitet. Eine automatische Löschung der verarbeiteten Daten erfolgt nach 6 Monaten.</p>

                    <h5>Widerrufsrecht</h5>

                    <p>Der/die Einwilligende hat das Recht, die Einwilligung jederzeit mit Wirkung für die Zukunft ohne Angabe von Gründen zu widerrufen. Ab Zugang der Widerrufserklärung werden die Daten unverzüglich gelöscht insofern keine gesetzlichen Aufbewahrungsfristen entgegenstehen und der Widerruf wirksam ist. Die Wirksamkeit der bis zum Widerruf der Einwilligung getätigten Datenverarbeitung bleibt unberührt.</p>

                    <p>Der Widerruf ist an die folgende E-Mail-Adresse zu richten: info@iswi.org</p>

                    <h5>Weitere Rechte des/der Einwilligenden</h5>

                    <p>Der/die Einwilligende besitzt auch das Recht der Löschung, der Sperrung, der Berichtigung und der Übertragbarkeit der Daten, sowie der Auskunft über die Datenverarbeitung. Die Geltendmachung dieser Rechte ist an folgende E-Mail-Adresse zu richten: info@iswi.org</p>

                    <h5>Folgen der Nichtunterzeichnung</h5>

                    <p>Der/die Unterzeichnende hat außerdem das Recht, allen oder einem der Zwecke dieser Einwilligungserklärung nicht zuzustimmen. Daher sind nur die Zwecke anzukreuzen, denen zugestimmt werden soll.</p>

                    <p>Die Datenverarbeitung ist für den Zweck der Durchführung der Veranstaltung "Kitchen Run" notwendig. Die Nichtzustimmung schließt die Dienste durch den ISWI e.V. aus.</p>


                    <h5>Freiwillige Zustimmung</h5>

                    <p>Hiermit versichert der/die Unterzeichnende, der Erhebung und Verarbeitung der personenbezogenen Daten durch den ISWI e.V. zum folgenden Zweck der Durchführung der Veranstaltung des Kitchen-Runs freiwillig zuzustimmen. Eine ordnungsgemäße Belehrung über das Widerrufsrecht fand statt.</p>

                </div>
            </div>

            <!-- Fancy Checkboxes -->
            <div class="kr_check">
                <input type="checkbox" name="kr_team_privacy_aggreement" id="kr_privacy_aggreement" <?php if (isset($_POST['kr_team_privacy_aggreement'])) echo "checked" ?> required>
                <label for="kr_privacy_aggreement" class="kr_label">We have read and understood the privacy agreement!</label>
            </div>

            <input type="button" name="kr_prev" class="kr_btn_prev" value="Previous" />

            <input type="submit" name="kr_team_submitted" class="kr_btn_submit" value="Submit" />

        </fieldset>

        <fieldset id="kr_tab_hidden" class="kr_tab">
            <h4 class="kr_step_subtitle">Course Preferences</h4>
            <p class="kr_step_description">Please use this selection carefully. It is only preference!</p>

            <!-- just needed for verification -->
            <input type="hidden" name="course_pref" id="kr_course_pref">

            <div class="kr_chbox">
                <input type="checkbox" name="kr_team_appetizer" id="kr_appetizer" class="kr_course" checked>
                <label for="kr_appetizer">Appetizer</label>
            </div>

            <div class="kr_chbox">
                <input type="checkbox" name="kr_team_main_course" id="kr_main_course" class="kr_course" checked>
                <label for="kr_main_course">Main Course</label>
            </div>

            <div class="kr_chbox">
                <input type="checkbox" name="kr_team_dessert" id="kr_dessert" class="kr_course" checked>
                <label for="kr_dessert">Dessert</label>
            </div>

            <input type="button" name="kr_prev" class="kr_btn_prev" value="Previous" />

            <input type="button" name="kr_next" class="kr_btn_next" value="Next" />

        </fieldset>

    </form>

</div>
