<?php
use League\Plates\Template\Template;

/**
 * Renders Template for Team Confirmation Mail.
 *
 * @since   1.0.0
 * @TODO    more content in mail
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var     Template    $this               Template Object to render
 * @var     string      $plugin_text_domain Translation Domain
 */
?>

<p>
    <?= __('Your Registration for Kitchen Run was successful. You will get more information over this E-Mail soon. Please inform us of all changes in your status over kitchenrun@iswi.org.', $plugin_text_domain) ?>
</p>
