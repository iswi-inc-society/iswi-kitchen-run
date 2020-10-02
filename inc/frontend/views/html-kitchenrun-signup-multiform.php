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

    <h2>Kitchen Run Signup</h2>

    <ul class="kr_progressbar">
        <li>Team</li>
        <li>Contact</li>
        <li>Address</li>
        <li>Food</li>
        <li>Courses</li>
        <li>Submit</li>
    </ul>

	<?php if (isset($errors)): ?>
	<?php foreach ($errors as $error): ?>
        <div class="kr-error-msg">
			<?= $error ?>
        </div>
	<?php endforeach ?>
    <?php endif; ?>

    <form id="kr_signup" class="kr_signup" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">

        <fieldset id="kr_tab_1" class="kr_tab">
            <h4 class="kr_step_subtitle">Team Information</h4>
            <p class="kr_step_description">Please choose a Team Name and tell us your names. One team member is at least required.</p>

            <div class="kr_txtb">
                <input type="text" id="kr_team_name" name="kr_team_name" required>
                <span data-placeholder="Team Name"></span>
            </div>

            <div class="kr_txtb">
                <input type="text" name="kr_team_member_1" required>
                <span data-placeholder="Team Member 1"></span>
            </div>

            <div class="kr_txtb">
                <input type="text" name="kr_team_member_2">
                <span data-placeholder="Team Member 2"></span>
            </div>

            <input type="button" name="kr_next" class="kr_btn_next" value="Next" />

        </fieldset>

        <fieldset id="kr_tab_2" class="kr_tab">
            <h4 class="kr_step_subtitle">Contact Information</h4>
            <p class="kr_step_description">The E-Mail Address is needed to send your team the informations for the evening. At the end of the sign up you need to confirm your E-Mail Address.</p>

            <div class="kr_txtb">
                <input type="email" name="kr_team_email" required>
                <span data-placeholder="E-Mail"></span>
            </div>

            <div class="kr_txtb">
                <input type="tel" name="kr_team_phone" required>
                <span data-placeholder="Phone Number"></span>
            </div>

            <input type="button" name="kr_prev" class="kr_btn_prev" value="Previous" />

            <input type="button" name="kr_next" class="kr_btn_next" value="Next" />

        </fieldset>


        <fieldset id="kr_tab_3" class="kr_tab">
            <h4 class="kr_step_subtitle">Address Information</h4>
            <p class="kr_step_description">Your address is needed so that your guests can find you. The description is only needed when your home is not so easy to find.</p>

            <div class="kr_txtb">
                <input type="text" name="kr_team_address" required>
                <span data-placeholder="Address"></span>
            </div>

            <div class="kr_txtb">
                <input type="text" name="kr_team_city" required>
                <span data-placeholder="City"></span>
            </div>

            <div class="kr_txtb">
                <textarea name="kr_team_find_place"></textarea>
                <span data-placeholder="Description to find my place (if it is difficult to find)"></span>
            </div>


            <input type="button" name="kr_prev" class="kr_btn_prev" value="Previous" />

            <input type="button" name="kr_next" class="kr_btn_next" value="Next" />

        </fieldset>

        <fieldset id="kr_tab_4" class="kr_tab">
            <h4 class="kr_step_subtitle">Food Preferences</h4>
            <p class="kr_step_description">Please tell us your food preferences, multiple selections are possible. Please use the text field, if you have allergies or something else. The informations will be sent to the cooking team.</p>

            <!-- just needed for verification -->
            <input type="hidden" name="food_pref" id="kr_food_pref">

            <div class="kr_chbox">
                <input type="checkbox" name="kr_team_vegan" id="kr_vegan" class="kr_food">
                <label for="kr_vegan">Vegan</label>
            </div>

            <div class="kr_chbox">
                <input type="checkbox" name="kr_team_vegetarian" id="kr_veggie" class="kr_food">
                <label for="kr_veggie">Vegetarian</label>
            </div>

            <div class="kr_chbox">
                <input type="checkbox" name="kr_team_halal" id="kr_halal" class="kr_food">
                <label for="kr_halal">Halal</label>
            </div>

            <div class="kr_chbox">
                <input type="checkbox" name="kr_team_kosher" id="kr_kosher" class="kr_food">
                <label for="kr_kosher">Kosher</label>
            </div>

            <div class="kr_chbox">
                <input type="checkbox" name="kr_team_everything" id="kr_all" class="kr_food">
                <label for="kr_all">I eat everything!</label>
            </div>

            <div class="kr_txtb">
                <textarea class="team_food_request" name="kr_team_food_request"></textarea>
                <span data-placeholder="Allergies, Food Requests, ..."></span>
            </div>

            <input type="button" name="kr_prev" class="kr_btn_prev" value="Previous" />

            <input type="button" name="kr_next" class="kr_btn_next" value="Next" />

        </fieldset>


        <fieldset id="kr_tab_5" class="kr_tab">
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

        <fieldset id="kr_tab_6" class="kr_tab">
            <h4 class="kr_step_subtitle">Submit</h4>
            <p class="kr_step_description">It is time to submit your kitchen run registration. You will get an verification E-Mail after that!</p>

            <div class="kr_txtb">
                <textarea name="kr_team_comment"></textarea>
                <span data-placeholder="Place for some general comments"></span>
            </div>

            <!-- Fancy Checkboxes -->
            <div class="kr_check">
                <input type="checkbox" name="kr_team_privacy_aggreement" id="kr_privacy_aggreement" required>
                <label for="kr_privacy_aggreement" class="kr_label">We have read and understood the privacy agreement!</label>
            </div>

            <input type="button" name="kr_prev" class="kr_btn_prev" value="Previous" />

            <input type="submit" name="kr_team_submitted" class="kr_btn_submit" value="Submit" />

        </fieldset>

    </form>

</div>
