<?php

use KitchenRun\Inc\Common\Model\Event;
use KitchenRun\Inc\Common\Model\Team;
use League\Plates\Template\Template;

/**
 * View to render a form to confirm that the user wants to send all confirmation emails.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var       Team[]      $teams             All Valid Teams that will get emails
 * @var       Event     $event              Event Object
 * @var       Template  $this               Templating Engine
 * @var       string    $title              Title of the Page
 * @var       string    $plugin_text_domain Language Domain
 * @var       string    $submit             "Send Mails"
 * @var       string    $nonce_name
 * @var       string    $nonce_field
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">

	<?php $this->insert('html-notices') ?>

	<h1 class="wp-heading-inline"><?= $this->e($title) ?></h1>

	<p><?php _e('You have specified this event for sending information emails: ', $plugin_text_domain); ?></p>


	<?php if(!$event->getPaired()): ?>
		<p style="color: darkred"><?= $this->e(__('Emails can\'t be send because it is not paired. Pair all Teams of the Event before deleting them.', $plugin_text_domain)) ?></p>
	<?php else: ?>
		<form id="send_mails" name="send_mails" method="post">
			<?php wp_nonce_field( $nonce_name, $nonce_field); ?>


			<input type="hidden" name="event" value="<?php echo $event->getId(); ?>">
			<p>ID#<?php echo $event->getId()?>: <?php echo $event->getName(); ?></p>

			<p><?= $this->e(__('The following E-Mail Addresses will get an information E-Mail:', $plugin_text_domain)) ?></p>
			<ul>
				<?php foreach ($teams as $team): ?>
				<li><?= $team->getEmail() ?></li>
				<?php endforeach; ?>
			</ul>

			<input type="hidden" name="send_mails_option" value="send">
			<input type="hidden" name="action" value="sendmails">

			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?= $submit ?>"></p>
		</form>
	<?php endif; ?>
</div>