<?php
use KitchenRun\Inc\Admin\Event_New;

/**
 * View to render a success message after the user created a new Event.
 *
 * @since     1.0.0
 *
 * @author    Niklas Loos <niklas.loos@live.com>
 *
 * @var       Event_New     $this  Event_New Object that has the plugin_text_domain variable.
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2><?php _e('New Kitchen Run Events', $this->plugin_text_domain); ?></h2>
    <p><?php __('Event was successfully created!', $this->plugin_text_domain); ?></p>
</div>