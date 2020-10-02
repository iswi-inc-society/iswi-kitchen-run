<?php

use League\Plates\Template\Template;

/**
 * View to render the team sign up form.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var     Template $this Template Object to render
 * @var     string $plugin_text_domain Translation Domain
 * @var     string $contact Contact E-Mail
 * @var     string $opening_date Opening Date String
 * @var     string $closing_date Closing Date String
 * @var     string $event_date Event Date String
 * @var     string      $state                  state of form
 * @var     string $verify_msg  Message for Verification
 * @var     string $verify_state  VALID, SUC, ERROR
 */

?>


<?php $this->insert('html-kitchenrun-signup-info', [
	'plugin_text_domain' => $plugin_text_domain,
	'state'         => $state,
	'opening_date'  => $opening_date,
	'closing_date'  => $closing_date,
	'event_date'    => $event_date
]);
?>

<div class="kr_container">

	<h2>Kitchen Run Signup</h2>

	<?php if ($verify_state == 'VALID' || $verify_state == 'SUC'): ?>
    <ul class="kr_progressbar">
        <li class="kr_active">Team</li>
        <li class="kr_active">Contact</li>
        <li class="kr_active">Address</li>
        <li class="kr_active">Food</li>
        <li class="kr_active">Courses</li>
        <li class="kr_active">Submit</li>
    </ul>
	<?php endif; ?>

    <?php if ($verify_state == 'VALID'): ?>
        <div class="kr_signup_success">
            <p><?= $verify_msg?></p>
        </div>
    <?php elseif ($verify_state == 'SUC'): ?>
        <div class="kr_signup_success">
            <p><?= $verify_msg?></p>
        </div>
    <?php else: ?>
        <div class="kr_signup_error">
            <p><?= $verify_msg?></p>
        </div>
    <?php endif; ?>



</div>