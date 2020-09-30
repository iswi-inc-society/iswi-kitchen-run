<?php

use KitchenRun\Inc\Frontend\Signup;
use League\Plates\Template\Template;

/**
 * View to render a Message that gives information about the current Kitchen Run Event.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var     Template    $this       Template Object to render
 * @var     string      $message    Information about current Kitchen Run Event
 * @var     array       $errors     All error messages?
 * @var     Signup      $signup     Sign Up Object fro rendering.
 * @var     string      $state      State of EVENT or SIGNUP
 */
?>

<?php foreach ($errors as $error): ?>
<div class="kr-error-msg">
    <?= $error ?>
</div>
<?php endforeach ?>

<p class="kr-signup-info">
    <?php echo $message ?>
</p>

<?php if ($state == 'SIGNUP'): ?>
    <?php $signup->render(); ?>
<?php endif; ?>
