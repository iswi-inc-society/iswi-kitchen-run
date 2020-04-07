<?php
/**
 * View to render the team sign up form.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 */
?>


<form id="kr_signup" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
    <label for="kr_signup_email">Team Name</label>
    <input required="true" type="text" id="kr_signup_name" name="kr_team_name" pattern="[a-zA-Z0-9 ]+" size="40" required/>

    <label for="kr_signup_member_1">Team Member 1</label>
    <input required="true" type="text" id="kr_signup_member_1" name="kr_team_member_1" pattern="[a-zA-Z0-9 ]+" size="40" required/>

    <label for="kr_signup_member_2">Team Member 2</label>
    <input required="true" type="text" id="kr_signup_member_2" name="kr_team_member_2" pattern="[a-zA-Z0-9 .]+" size="40" />

    <label for="kr_signup_address">Addresse</label>
    <input required="true" type="text" id="kr_signup_address" name="kr_team_address" pattern="[a-zA-Z0-9 ]+" size="40" required/>

    <label for="kr_signup_city">City</label>
    <input required="true" type="text" id="kr_signup_city" name="kr_team_city" pattern="[a-zA-Z0-9 ]+" size="40" value="Ilmenau" required/>

    <label for="kr_signup_email">E-Mail</label>
    <input type="email" id="kr_signup_email" name="kr_team_email" size="40" required/>

    <label for="kr_signup_phone">Phone Number</label>
    <input type="tel" id="kr_signup_phone" name="kr_team_phone" pattern="[0-9 ]+" size="40" required/>

    <span>Do you eat something not?</span>

    <br>

    <input type="radio" id="kr_signup_vegan" name="team_food_preference" />
    <label for="kr_signup_vegan" style="display: inline">Vegan</label>

    <input type="radio" id="kr_signup_vegetarian" name="team_food_preference" />
    <label for="kr_signup_vegetarian" style="display: inline">Vegetarian</label>

    <input type="radio" id="kr_signup_halal" name="team_food_preference" />
    <label for="kr_signup_halal" style="display: inline">Halal</label>

    <input type="radio" id="kr_signup_kosher" name="team_food_preference" />
    <label for="kr_signup_kosher" style="display: inline">Kosher</label>

    <input type="radio" id="kr_signup_everything" name="team_food_preference" />
    <label for="kr_signup_everything" style="display: inline">Everything</label>

    <br>


    <label for="kr_signup_food_request">Special requests about food, they will be sent to the other teams where you will eat</label>
    <textarea form="kr_signup" id="kr_signup_food_request" name="kr_team_food_request"></textarea>

    <label for="kr_signup_find_place">If it is not easy, give hints on how to find your place</label>
    <textarea form="kr_signup" id="kr_signup_find_place" name ="kr_team_find_place"></textarea>

    <span>We are able to cook the following courses:</span>

    <br>

    <input type="checkbox" id="kr_signup_appetizer" name="kr_team_appetizer" checked />
    <label for="kr_signup_appetizer">Appetizer</label>

    <input type="checkbox" id="kr_signup_main_course" name="kr_team_main_course" checked />
    <label for="kr_signup_main_course">Main Course</label>

    <input type="checkbox" id="kr_signup_dessert" name="kr_team_dessert" checked />
    <label for="kr_signup_dessert">Dessert</label>

    <br>

    <label for="kr_signup_comment">Comments for the organization (they will not be shared)</label>
    <textarea form="kr_signup" id="kr_signup_comment" name="kr_team_comment"></textarea>

    <input type="checkbox" id="kr_signup_infos_events" name="kr_team_infos_events" checked />
    <label for="kr_signup_infos_events">We would like to receive e-mails informing us about upcoming events.</label>

    <br>

    <input type="checkbox" id="kr_signup_infos_iswi" name="kr_team_infos_iswi" checked />
    <label for="kr_signup_infos_iswi">We would like to receive e-mails informing us about ISWI e.V. in general.</label>

    <br>

    <input type="checkbox" id="kr_signup_privacy" name="kr_team_privacy" checked required />
    <label for="kr_signup_privacy">We have read and understood the privacy agreement.</label>

    <br>

    <input type="submit" id="kr_signup_submitted" name="kr_team_submitted" value="Send" style="width: 100%">
</form>
