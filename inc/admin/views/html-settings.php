<?php

use League\Plates\Template\Template;

/**
 * View to render the Settings Page for Kitchen Run.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var     Template            $this    Event Page Object has the needed Event_Table_List object as property.
 * @var     string              $title   Title of the Page
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->


<div class="wrap">

	<?php $this->insert('html-notices') ?>

    <h1><?= $this->e( $title ); ?></h1>
    <!--suppress HtmlUnknownTarget -->
    <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "wporg"
        settings_fields( 'kitchenrun' );
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections( 'kitchenrun_settings' );
        // output save settings button
        submit_button( 'Save Settings' );
        ?>
    </form>
</div>