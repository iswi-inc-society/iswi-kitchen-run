<?php

use KitchenRun\Inc\Admin\Team_Page;
use KitchenRun\Inc\Common\Model\Pair;

/**
 * View to render a Table with all pairs that also has a form to exchange pairs.
 * The selection of pairs is done with javascript. Look in wp-kitchenrun-admin.js.
 *
 * @since     1.0.0
 * @TODO      Improve Table Design.
 *
 * @author    Niklas Loos <niklas.loos@live.com>
 *
 * @var       Team_Page     $this   Team_Page Object that has the plugin_text_domain variable.
 * @var       Pair[]        $pairs  Array of all Pairs of the Event.
 */
?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Pairs', $this->plugin_text_domain); ?></h1>

    <!-- Table Form to exchange pairs -->
    <div class="tablenav top">
        <div class="alignleft actions">
            <form id="exg_pairs" method="post">
                <input type="hidden" name="guest_exg_1" class="guest-exg-1">
                <input type="hidden" name="guest_exg_2" class="guest-exg-2">
                <input type="hidden" name="exg_pairs_submit">
                <?php wp_nonce_field( 'exg_pairs', '_wpnonce_exg_pairs' ); ?>
                <?php submit_button( __( 'Exchange Pairs' ), 'submit', 'exg_pairs_action', false, array( 'disabled' => 'true' ) ); ?>
            </form>
        </div>
    </div>

    <!-- Table -->
    <table class="tl-pairs fixed striped widefat">
        <tbody>
            <tr id="row-appetizer">
                <th><?php echo __('Appetizer', $this->plugin_text_domain) ?></th>
                <?php foreach ($pairs as $pair): ?>
                <?php if($pair->getCourse() == 0): ?>
                    <td id="pair-<?php echo $pair->getId(); ?>">
                        <div id="cook-<?php echo $pair->getId(); ?>" class="appetizer pair-cook"><?php echo $pair->getCook()->getName(); ?></div>
                        <div id="guest1-<?php echo $pair->getId(); ?>" class="appetizer pair-guest1 pair-guest"><?php echo $pair->getGuest1()->getName(); ?></div>
                        <div id="guest2-<?php echo $pair->getId(); ?>" class="appetizer pair-guest2 pair-guest"><?php echo $pair->getGuest2()->getName(); ?></div>
                    </td>
                <?php endif; ?>
                <?php endforeach; ?>
            </tr>
            <tr id="row-main-course">
                <th><?php echo __('Main Course', $this->plugin_text_domain) ?></th>
                <?php foreach ($pairs as $pair): ?>
                    <?php if($pair->getCourse() == 1): ?>
                        <td id="pair-<?php echo $pair->getId(); ?>">
                            <div id="cook-<?php echo $pair->getId(); ?>" class="main-course pair-cook"><?php echo $pair->getCook()->getName(); ?></div>
                            <div id="guest1-<?php echo $pair->getId(); ?>" class="main-course pair-guest1 pair-guest"><?php echo $pair->getGuest1()->getName(); ?></div>
                            <div id="guest2-<?php echo $pair->getId(); ?>" class="main-course pair-guest2 pair-guest"><?php echo $pair->getGuest2()->getName(); ?></div>
                        </td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
            <tr id="row-dessert">
                <th><?php echo __('Dessert', $this->plugin_text_domain) ?></th>
                <?php foreach ($pairs as $pair): ?>
                    <?php if($pair->getCourse() == 2): ?>
                        <td id="pair-<?php echo $pair->getId(); ?>">
                            <div id="cook-<?php echo $pair->getId(); ?>" class="dessert pair-cook"><?php echo $pair->getCook()->getName(); ?></div>
                            <div id="guest1-<?php echo $pair->getId(); ?>" class="dessert pair-guest1 pair-guest"><?php echo $pair->getGuest1()->getName(); ?></div>
                            <div id="guest2-<?php echo $pair->getId(); ?>" class="dessert pair-guest2 pair-guest"><?php echo $pair->getGuest2()->getName(); ?></div>
                        </td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
</div>