<?php
/**
 * Add Kitchen Run Notices for Success/Error/Info Messages to the wordpress page!
 *
 * @var array $_SESSION Session Array of the Kitchen Run Plugin
 */
?>

<?php if (isset($_SESSION['kr_notice'])): ?>

	<?php foreach ($_SESSION['kr_notice'] as $type => $messages): ?>

		<?php foreach ($messages as $key => $message): ?>

			<div class="kr_notice_<?= $type ?> notice inline notice-<?= $type ?> notice-alt">
				<p><?= $message ?></p>
			</div>

			<?php unset($_SESSION['kr_notice'][$type][$key]) ?>

		<?php endforeach; ?>


	<?php endforeach; ?>

<?php endif; ?>
