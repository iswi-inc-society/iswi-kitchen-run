<?php
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
 */
?>

<p class="info">
    <?php echo $message ?>
</p>
