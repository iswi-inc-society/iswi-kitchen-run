<?php


use KitchenRun\Inc\Common\Model\Pair;
use KitchenRun\Inc\Common\Model\Team;
use League\Plates\Template\Template;

/**
 * Information Mail Log
 *
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var     Template    $this       Template Object to render
 * @var     int         $errors     Number of Errors
 * @var     string[]    $error_msg  Error Messages
 * @var     boolean[]|string[] $messages
 *
 */
?>

<?php if($errors == 0): ?>

	<?php foreach ($messages as $message) : ?>

		<?php if ($message['succ']): ?>
			<div class="kr_succ">
				Information Mail successfully sent to <?= $message['mail'] ?>.
			</div>
		<?php else : ?>
			<div class="kr_error">
				There was an error when sending the information email to <?= $message['mail'] ?>.
			</div>
		<?php endif; ?>

	<?php endforeach; ?>

<?php else : ?>

	<p>There were error during the mail creation, mails couldn't be send:</p>

	<?php foreach ($error_msg as $msg) : ?>
		<div class="kr_error">
			<?= $msg ?>
		</div>
	<?php endforeach; ?>

<?php endif; ?>
