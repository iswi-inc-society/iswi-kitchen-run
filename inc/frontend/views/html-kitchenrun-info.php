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
 * @var     boolean     $su         Is SignUp rendered?
 * @var     Signup      $signup     Sign Up Object fro rendering.
 */
?>

<p class="kr-signup-info">
    <?php echo $message ?>
</p>

<?php if ($su): ?>
    <?php $signup->render(); ?>
<?php endif; ?>
