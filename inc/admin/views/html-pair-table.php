<?php

use KitchenRun\Inc\Common\Model\Pair;
use League\Plates\Template\Template;

/**
 * View to render a Table with all pairs that also has a form to exchange pairs.
 * The selection of pairs is done with javascript. Look in wp-kitchenrun-admin.js.
 *
 * @since     1.0.0
 * @TODO      Improve Table Design.
 *
 * @author    Niklas Loos <niklas.loos@live.com>
 *
 * @var       Pair[]    $pairs              Array of all Pairs of the Event.
 * @var       Template  $this               Event Page Object has the needed Event_Table_List object as property.
 * @var       string    $title              Title of the Page
 * @var       string    $plugin_text_domain Language Domain
 * @var       string    $exchange           Translation of Exchange Pairs
 * @var       string    $smails             Translation of Send Information
 */
?>
<div class="wrap">

	<?php $this->insert('html-notices') ?>

    <h1 class="wp-heading-inline"><?= $this->e($title) ?></h1>

    <!-- Table Form to exchange pairs -->
    <div class="tablenav top">
        <div class="alignleft actions">
            <form id="exg_pairs" method="post">
                <input type="hidden" name="guest_exg_1" class="guest-exg-1">
                <input type="hidden" name="guest_exg_2" class="guest-exg-2">
                <input type="hidden" name="exg_pairs_submit">
                <?php wp_nonce_field( 'exg_pairs', '_wpnonce_exg_pairs' ); ?>
                <?php submit_button( $this->e($exchange), 'submit', 'exg_pairs_action', false, array( 'disabled' => 'true' ) ); ?>
            </form>

        </div>
        <div class="alignleft actions">
            <a class="button submit" href="?page=<?php echo $_REQUEST['page'] ?>&action=info_mails"> <?php echo __('Send Information Mails', $plugin_text_domain); ?> </a>
        </div>
    </div>



    <!-- Table -->
    <table class="tl-pairs fixed striped widefat">
        <tbody>
            <tr id="row-appetizer">
                <th><?= __('Appetizer', $plugin_text_domain) ?></th>
                <?php foreach ($pairs as $pair): ?>
                <?php if($pair->getCourse() == 0): ?>

                    <?php $this->insert('html-pair-cell', ['pair' => $pair, 'course_class' => 'appetizer']) ?>

                <?php endif; ?>
                <?php endforeach; ?>
            </tr>
            <tr id="row-main-course">
                <th><?= __('Main Course', $plugin_text_domain) ?></th>
                <?php foreach ($pairs as $pair): ?>
                    <?php if($pair->getCourse() == 1): ?>
                        <?php $this->insert('html-pair-cell', ['pair' => $pair, 'course_class' => 'main-course']) ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
            <tr id="row-dessert">
                <th><?= __('Dessert', $plugin_text_domain) ?></th>
                <?php foreach ($pairs as $pair): ?>
                    <?php if($pair->getCourse() == 2): ?>
                        <?php $this->insert('html-pair-cell', ['pair' => $pair, 'course_class' => 'dessert']) ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
</div>