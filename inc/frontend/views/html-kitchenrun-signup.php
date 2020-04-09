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
    <label for="kr_signup_name"><?= $this->e(__('Team Name', $plugin_text_domain)) ?></label>
    <input type="text" id="kr_signup_name" name="kr_team_name" pattern="[a-zA-Z0-9 ]+" size="40" required/>

    <label for="kr_signup_member_1"><?= $this->e(__('Team Member 1', $plugin_text_domain)) ?></label>
    <input type="text" id="kr_signup_member_1" name="kr_team_member_1" pattern="[a-zA-Z0-9 ]+" size="40" required/>

    <label for="kr_signup_member_2"><?= $this->e(__('Team Member 2', $plugin_text_domain)) ?></label>
    <input type="text" id="kr_signup_member_2" name="kr_team_member_2" pattern="[a-zA-Z0-9 .]+" size="40" />

    <label for="kr_signup_address"><?= $this->e(__('Address', $plugin_text_domain)) ?></label>
    <input type="text" id="kr_signup_address" name="kr_team_address" pattern="[a-zA-Z0-9 ]+" size="40" required/>

    <label for="kr_signup_city"><?= $this->e(__('City', $plugin_text_domain)) ?></label>
    <input type="text" id="kr_signup_city" name="kr_team_city" pattern="[a-zA-Z0-9 ]+" size="40" value="Ilmenau" required/>

    <label for="kr_signup_email"><?= $this->e(__('E-Mail', $plugin_text_domain)) ?></label>
    <input type="email" id="kr_signup_email" name="kr_team_email" size="40" required/>

    <label for="kr_signup_phone"><?= $this->e(__('Phone Number', $plugin_text_domain)) ?></label>
    <input type="tel" id="kr_signup_phone" name="kr_team_phone" pattern="[0-9 ]+" size="40" required/>

    <span><?= $this->e(__('Do you have any food preferences?', $plugin_text_domain)) ?></span>

    <br>

    <input type="radio" id="kr_signup_vegan" name="team_food_preference" />
    <label for="kr_signup_vegan" style="display: inline"><?= $this->e(__('vegan', $plugin_text_domain)) ?></label>

    <input type="radio" id="kr_signup_vegetarian" name="team_food_preference" />
    <label for="kr_signup_vegetarian" style="display: inline"><?= $this->e(__('vegetarian', $plugin_text_domain)) ?></label>

    <input type="radio" id="kr_signup_halal" name="team_food_preference" />
    <label for="kr_signup_halal" style="display: inline"><?= $this->e(__('halal', $plugin_text_domain)) ?></label>

    <input type="radio" id="kr_signup_kosher" name="team_food_preference" />
    <label for="kr_signup_kosher" style="display: inline"><?= $this->e(__('kosher', $plugin_text_domain)) ?></label>

    <input type="radio" id="kr_signup_everything" name="team_food_preference" />
    <label for="kr_signup_everything" style="display: inline"><?= $this->e(__('I eat everything', $plugin_text_domain)) ?></label>

    <br>


    <label for="kr_signup_food_request"><?= $this->e(__('Other special request for food, they will be sent to the cooking team', $plugin_text_domain)) ?>:</label>
    <textarea form="kr_signup" id="kr_signup_food_request" name="kr_team_food_request"></textarea>

    <label for="kr_signup_find_place"><?= $this->e(__('If it is not easy, give hints on how to find your place', $plugin_text_domain)) ?>:</label>
    <textarea form="kr_signup" id="kr_signup_find_place" name ="kr_team_find_place"></textarea>

    <span><?= $this->e(__('We are able to cook the following courses', $plugin_text_domain)) ?>:</span>

    <br>

    <input type="checkbox" id="kr_signup_appetizer" name="kr_team_appetizer" checked />
    <label for="kr_signup_appetizer"><?= $this->e(__('Appetizer', $plugin_text_domain)) ?></label>

    <input type="checkbox" id="kr_signup_main_course" name="kr_team_main_course" checked />
    <label for="kr_signup_main_course"><?= $this->e(__('Main Course', $plugin_text_domain)) ?></label>

    <input type="checkbox" id="kr_signup_dessert" name="kr_team_dessert" checked />
    <label for="kr_signup_dessert"><?= $this->e(__('Dessert', $plugin_text_domain)) ?></label>

    <br>

    <label for="kr_signup_comment"><?= $this->e(__('Comments for the organization (they will not be shared)', $plugin_text_domain)) ?></label>
    <textarea form="kr_signup" id="kr_signup_comment" name="kr_team_comment"></textarea>

    <!-- NOT SAVED YET -->
    <input type="checkbox" id="kr_signup_infos_events" name="kr_team_infos_events" checked />
    <label for="kr_signup_infos_events"><?= $this->e(__('We would like to receive e-mails informing us about upcoming events', $plugin_text_domain)) ?></label>

    <br>

    <!-- NOT SAVED YET -->
    <input type="checkbox" id="kr_signup_infos_iswi" name="kr_team_infos_iswi" checked />
    <label for="kr_signup_infos_iswi"><?= $this->e(__('We would like to receive e-mails informing us about ISWI e.V. in general', $plugin_text_domain)) ?></label>

    <br>

    <input type="checkbox" id="kr_signup_privacy" name="kr_team_privacy" checked required />
    <label for="kr_signup_privacy"><?= $this->e(__('We have read and understood the privacy agreement', $plugin_text_domain)) ?></label>

    <br>

    <input type="submit" id="kr_signup_submitted" name="kr_team_submitted" value="<?= $this->e(__('Send', $plugin_text_domain)) ?>" style="width: 100%">
</form>
