<?php

use KitchenRun\Inc\Common\Model\Team;
use League\Plates\Template\Template;

/**
 * View to render a form to edit existing teams in the wordpress backend.
 *
 * @since     1.0.0
 *
 * @author    Niklas Loos <niklas.loos@live.com>
 *
 * @var       Team      $team               Team Object that will be edited.
 * @var       Template  $this               Event Page Object has the needed Event_Table_List object as property.
 * @var       string    $title              Title of the Page
 * @var       string    $plugin_text_domain Language Domain
 * @var       array     $event_options      Array of all Event Names
 * @var       string    $submit             Translation for Submit field
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2><?php _e($title, $plugin_text_domain); ?></h2>

    <div id="wp-form-kr-update-team">
        <div id="kr-form-body">
            <form id="kr_update_team" name="kr_update_team" method="post">

                <?php wp_nonce_field( 'update_team', '_wpnonce_update_team' ); ?>

                <input type="hidden" name="team_id" value="<?php echo $team->getId() ?>">
                <input type="hidden" name="team_submit" value="submitted">

                <table id="update_team" class="form-table" role="presentation">

                    <tr class="form-field form-required">
                        <th scope="row"><label for="kr_update_team_name"><?php _e('Team Name', $plugin_text_domain); ?></label></th>
                        <td><input id="kr_update_team_name" type="text" name="team_name" value="<?php echo $team->getName() ?>" required /></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label for="kr_update_team_member_1"><?php _e('Member 1', $plugin_text_domain); ?></label></th>
                        <td><input id="kr_update_team_member_1" type="text" name="team_member_1" value="<?php echo $team->getMember1() ?>" required /></td>
                    </tr>

                    <tr class="form-field">
                        <th scope="row"><label for="kr_update_team_member_2"><?php _e('Member 2', $plugin_text_domain); ?></label></th>
                        <td><input id="kr_update_team_member_2" type="text" name="team_member_2" value="<?php echo $team->getMember2() ?>" required /></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label for="kr_update_team_address"><?php _e('Address', $plugin_text_domain); ?></label></th>
                        <td><input id="kr_update_team_address" type="text" name="team_address" value="<?php echo $team->getAddress() ?>" required /></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label for="kr_update_team_city"><?php _e('City', $plugin_text_domain); ?></label></th>
                        <td><input id="kr_update_team_city" type="text" name="team_city" value="<?php echo $team->getCity() ?>" required /></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label for="kr_update_team_email"><?php _e('E-Mail', $plugin_text_domain); ?></label></th>
                        <td><input id="kr_update_team_email" type="email" name="team_email" value="<?php echo $team->getEmail() ?>" required /></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label for="kr_update_team_phone"><?php _e('Phone Number', $plugin_text_domain); ?></label></th>
                        <td><input id="kr_update_team_phone" type="text" name="team_phone" value="<?php echo $team->getPhone() ?>" required /></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label><?php _e('Food Preferences', $plugin_text_domain); ?></label></th>
                        <td><fieldset>
                            <input value="vegan" type="radio" id="kr_signup_vegan" name="team_food_preference" <?php if ($team->getVegan()) echo 'checked'; ?> />
                            <label for="kr_signup_vegan" style="display: inline"><?php _e('Vegan', $plugin_text_domain); ?></label>

                            <input value="vegetarian" type="radio" id="kr_signup_vegetarian" name="team_food_preference" <?php if ($team->getVegetarian()) echo 'checked'; ?> />
                            <label for="kr_signup_vegetarian" style="display: inline"><?php _e('Vegetarian', $plugin_text_domain); ?></label>

                            <input value="halal" type="radio" id="kr_signup_halal" name="team_food_preference" <?php if ($team->getHalal()) echo 'checked'; ?> />
                            <label for="kr_signup_halal" style="display: inline"><?php _e('Halal', $plugin_text_domain); ?></label>

                            <input value="kosher" type="radio" id="kr_signup_kosher" name="team_food_preference" <?php if ($team->getKosher()) echo 'checked'; ?> />
                            <label for="kr_signup_kosher" style="display: inline"><?php _e('Kosher', $plugin_text_domain); ?></label>

                            <input value="everything" type="radio" id="kr_signup_everything" name="team_food_preference" <?php if (!$team->getKosher() && !$team->getHalal() && !$team->getVegetarian() && !$team->getVegan()) echo 'checked'; ?> />
                            <label for="kr_signup_everything" style="display: inline"><?php _e('Everything', $plugin_text_domain); ?></label>
                        </fieldset></td>
                    </tr>

                    <tr class="form-field">
                        <th scope="row"><label for="kr_signup_food_request"><?php _e('Food Request', $plugin_text_domain); ?></label></th>
                        <td><textarea form="kr_update_team" id="kr_signup_food_request" name="team_food_request"><?php echo $team->getFoodRequest()?></textarea></td>
                    </tr>

                    <tr class="form-field">
                        <th scope="row"><label for="kr_update_team_find_place"><?php _e('Find Place', $plugin_text_domain); ?></label></th>
                        <td><textarea form="kr_update_team" id="kr_update_team_find_place" name="team_find_place"><?php echo $team->getFindPlace()?></textarea></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label><?php _e('Course Preferences', $plugin_text_domain); ?></label></th>
                        <td><fieldset>
                                <input type="checkbox" id="kr_update_team_appetizer" name="team_appetizer" <?php if ($team->getAppetizer()) echo 'checked'; ?> />
                                <label for="kr_update_team_appetizer" style="display: inline"><?php _e('Appetizer', $plugin_text_domain); ?></label>

                                <input type="checkbox" id="kr_update_team_main_course" name="team_main_course" <?php if ($team->getMainCourse()) echo 'checked'; ?> />
                                <label for="kr_update_team_main_course" style="display: inline"><?php _e('Appetizer', $plugin_text_domain); ?></label>

                                <input type="checkbox" id="kr_update_team_dessert" name="team_dessert" <?php if ($team->getDessert()) echo 'checked'; ?> />
                                <label for="kr_update_team_dessert" style="display: inline"><?php _e('Dessert', $plugin_text_domain); ?></label>
                            </fieldset></td>
                    </tr>

                    <tr class="form-field">
                        <th scope="row"><label for="kr_update_team_comment"><?php _e('Comment', $plugin_text_domain); ?></label></th>
                        <td><textarea form="kr_update_team" id="kr_update_team_comment" name="team_comment"><?php echo $team->getComments() ?></textarea></td>
                    </tr>

                    <tr class="form-field">
                        <th scope="row"><label for="kr_update_team_event"><?php _e('Event', $plugin_text_domain); ?></label></th>
                        <td>
                            <select id="kr_update_team_event" name="team_event">
                                <?php foreach ($event_options as $option): ?>
                                    <?= $option ?>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>


                </table>
                <p class="submit">
                    <input class="button button-primary" type="submit" name="event_submit" value="<?= $submit ?>" />
                </p>


            </form>
        </div>
    </div>
</div>