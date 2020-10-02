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
 * @var     string      $state      State of EVENT or SIGNUP
 * @var     string      $opening_date           Opening Date String
 * @var     string      $closing_date           Closing Date String
 * @var     string      $event_date             Event Date String
 */
?>
<?php if (isset($errors)): ?>
    <?php foreach ($errors as $error): ?>
    <div class="kr-error-msg">
        <?= $error ?>
    </div>
    <?php endforeach ?>
<?php endif; ?>

<?php if ($state == 'NO EVENT' || $state == 'AFTER_EVENT'): ?>
    <p class="kr-signup-info">
        There is no upcoming Kitchen Run Event!
    </p>
<?php elseif ($state == 'BEFORE_SIGNUP'): ?>
    <p class="kr-signup-info">
        The next Kitchen Run Event will be on the <?= $event_date ?>. If you are interested, the sign up starts on the <?= $opening_date ?>.
    </p>
<?php elseif ($state == 'AFTER_SIGNUP'): ?>
    <p class="kr-signup-info">
        The next Kitchen Run Event will be on the <?= $event_date ?>. The Sign Up is closed but, if you have questions contact kitchenrun@iswi.org.
    </p>
<?php else: ?>
    <p class="kr-signup-info">
        The next Kitchen Run Event will be on the <?= $event_date ?>. The Sign Up stays open until the <?= $closing_date ?>.
    </p>
<?php endif; ?>