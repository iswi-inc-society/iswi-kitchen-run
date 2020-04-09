<?php
use KitchenRun\Inc\Common\Model\Pair;
use League\Plates\Template\Template;

/**
 * View to render cells for the table with pairs.
 *
 * @since     1.0.0
 * @TODO      Improve Table Design.
 *
 * @author    Niklas Loos <niklas.loos@live.com>
 *
 * @var       Pair      $pair               Pair Object for current cell
 * @var       Template  $this               Template Object to render this template
 */

// to save database queries
$cook = $pair->getCook();
$guest1 = $pair->getGuest1();
$guest2 = $pair->getGuest2();
?>

<td id="pair-<?php echo $pair->getId(); ?>">
    <div id="cook-<?php echo $pair->getId(); ?>" class="appetizer pair-cook">
        <?php echo $cook->getName(); ?>
        <span class="food-pref">
            <?php $this->insert('html-team-food-pref-img', ['team' => $cook])?>
        </span>
    </div>

    <div id="guest1-<?php echo $pair->getId(); ?>" class="appetizer pair-guest1 pair-guest">
        <?php echo $pair->getGuest1()->getName(); ?>
        <span class="food-pref">
            <?php $this->insert('html-team-food-pref-img', ['team' => $guest1])?>
        </span>
    </div>

    <div id="guest2-<?php echo $pair->getId(); ?>" class="appetizer pair-guest2 pair-guest">
        <?php echo $pair->getGuest2()->getName(); ?>
        <span class="food-pref">
            <?php $this->insert('html-team-food-pref-img', ['team' => $guest2])?>
        </span>
    </div>
</td>
