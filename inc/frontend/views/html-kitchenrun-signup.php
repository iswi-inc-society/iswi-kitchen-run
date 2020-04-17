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
 */

?>


<form id="kr_signup" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">

    <?php $this->insert('form/html-kitchenrun-input-text', ['label' => __('Team Name', $plugin_text_domain), 'name'  => 'kr_team_name',]); ?>

    <?php $this->insert('form/html-kitchenrun-input-text', ['label' => __('Team Member 1', $plugin_text_domain), 'name'  => 'kr_team_member_1',]); ?>

    <?php $this->insert('form/html-kitchenrun-input-text', ['label' => __('Team Member 2', $plugin_text_domain), 'name'  => 'kr_team_member_2',]); ?>

    <?php $this->insert('form/html-kitchenrun-input-text', ['label' => __('Address', $plugin_text_domain), 'name'  => 'kr_team_address',]); ?>

    <?php $this->insert('form/html-kitchenrun-input-text', ['label' => __('City', $plugin_text_domain), 'name'  => 'kr_team_city',]); ?>

    <?php $this->insert('form/html-kitchenrun-input-text', ['label' => __('E-Mail', $plugin_text_domain), 'name'  => 'kr_team_email', 'type' => 'email']); ?>

    <?php $this->insert('form/html-kitchenrun-input-text', ['label' => __('Phone Number', $plugin_text_domain), 'name'  => 'kr_team_phone', 'type' => 'tel']); ?>


    <div class="kr_form_checkboxes">
        <span><?= $this->e(__('Do you have any food preferences?', $plugin_text_domain)) ?></span> <br>

        <div class="kr_form_check">
            <input type="radio" id="kr_signup_vegan" name="team_food_preference" />
            <label for="kr_signup_vegan" style="display: inline"><?= $this->e(__('vegan', $plugin_text_domain)) ?></label>
        </div>

        <div class="kr_form_check">
            <input type="radio" id="kr_signup_vegetarian" name="team_food_preference" />
            <label for="kr_signup_vegetarian" style="display: inline"><?= $this->e(__('vegetarian', $plugin_text_domain)) ?></label>
        </div>

        <div class="kr_form_check">
            <input type="radio" id="kr_signup_halal" name="team_food_preference" />
            <label for="kr_signup_halal" style="display: inline"><?= $this->e(__('halal', $plugin_text_domain)) ?></label>
        </div>

        <div class="kr_form_check">
            <input type="radio" id="kr_signup_kosher" name="team_food_preference" />
            <label for="kr_signup_kosher" style="display: inline"><?= $this->e(__('kosher', $plugin_text_domain)) ?></label>
        </div>

        <div class="kr_form_check">
            <input type="radio" id="kr_signup_everything" name="team_food_preference" />
            <label for="kr_signup_everything" style="display: inline"><?= $this->e(__('I eat everything', $plugin_text_domain)) ?></label>
        </div>
    </div>

    <div class="kr_form_textarea">
        <label for="kr_signup_food_request"><?= $this->e(__('Other special request for food, they will be sent to the cooking team', $plugin_text_domain)) ?>:</label>
        <textarea form="kr_signup" id="kr_signup_food_request" name="kr_team_food_request">Some Text</textarea>
    </div>

    <div class="kr_form_textarea">
        <label for="kr_signup_find_place"><?= $this->e(__('If it is not easy, give hints on how to find your place', $plugin_text_domain)) ?>:</label>
        <textarea form="kr_signup" id="kr_signup_find_place" name ="kr_team_find_place">Some Text</textarea>
    </div>

    <div class="kr_form_checkboxes">
        <span><?= $this->e(__('We are able to cook the following courses', $plugin_text_domain)) ?>:</span> <br>

        <div class="kr_form_check">
            <input type="checkbox" id="kr_signup_appetizer" name="kr_team_appetizer" checked />
            <label for="kr_signup_appetizer"><?= $this->e(__('Appetizer', $plugin_text_domain)) ?></label>
        </div>

        <div class="kr_form_check">
            <input type="checkbox" id="kr_signup_main_course" name="kr_team_main_course" checked />
            <label for="kr_signup_main_course"><?= $this->e(__('Main Course', $plugin_text_domain)) ?></label>
        </div>

        <div class="kr_form_check">
            <input type="checkbox" id="kr_signup_dessert" name="kr_team_dessert" checked />
            <label for="kr_signup_dessert"><?= $this->e(__('Dessert', $plugin_text_domain)) ?></label>
        </div>
    </div>

    <div class="kr_form_textarea">
        <label for="kr_signup_comment"><?= $this->e(__('Comments for the organization (they will not be shared)', $plugin_text_domain)) ?></label>
        <textarea form="kr_signup" id="kr_signup_comment" name="kr_team_comment">Some Comment</textarea>
    </div>

    <!-- NOT SAVED YET -->
    <div class="kr_form_checkboxes">
        <input type="checkbox" id="kr_signup_infos_events" name="kr_team_infos_events" checked />
        <label for="kr_signup_infos_events"><?= $this->e(__('We would like to receive e-mails informing us about upcoming events', $plugin_text_domain)) ?></label>
    </div>

    <!-- NOT SAVED YET -->
    <div class="kr_form_checkboxes">
        <input type="checkbox" id="kr_signup_infos_iswi" name="kr_team_infos_iswi" checked />
        <label for="kr_signup_infos_iswi"><?= $this->e(__('We would like to receive e-mails informing us about ISWI e.V. in general', $plugin_text_domain)) ?></label>
    </div>

    <div class="kr_form_checkboxes">
        <input type="checkbox" id="kr_signup_privacy" name="kr_team_privacy" checked required />
        <label for="kr_signup_privacy"><?= $this->e(__('We have read and understood the privacy agreement', $plugin_text_domain)) ?></label>
    </div>

    <div class="kr_form_submit">
        <input type="submit" id="kr_signup_submitted" name="kr_team_submitted" value="<?= $this->e(__('Send', $plugin_text_domain)) ?>" style="width: 100%">
    </div>
</form>
