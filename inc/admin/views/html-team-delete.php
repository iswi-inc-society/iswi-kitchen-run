<?php

use KitchenRun\Inc\Common\Model\Team;
use League\Plates\Template\Template;

/**
 * View to render a form to confirm that the user wants to delete a team.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var       Team      $team               Team Object that will be edited.
 * @var       Template  $this               Event Page Object has the needed Event_Table_List object as property.
 * @var       string    $title              Title of the Page
 * @var       string    $plugin_text_domain Language Domain
 * @var       string    $submit             Translation of Confirm Deletion
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h1 class="wp-heading-inline"><?= $this->e($title) ?></h1>

    <p><?php _e('You have specified this team for deletion: ', $plugin_text_domain); ?></p>



    <form id="delete_team" name="delete_team" method="post">
        <?php wp_nonce_field( 'delete_team_confirmation', '_wpnonce_delete_team' ); ?>


        <input type="hidden" name="team" value="<?php echo $team->getId(); ?>">
        <p>ID#<?php echo $team->getId()?>: <?php echo $team->getName(); ?></p>

        <input type="hidden" name="delete_option" value="delete">
        <input type="hidden" name="action" value="dodelete">

        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?= $submit ?>"></p>
    </form>
</div>