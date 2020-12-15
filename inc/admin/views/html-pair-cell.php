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
 * @var       string    $course_class       HTML Class to recognize course of the team
 */

// to save database queries
$cook = $pair->getCook();
$guest1 = $pair->getGuest1();
$guest2 = $pair->getGuest2();
?>

<td id="pair-<?php echo $pair->getId(); ?>">
    <div class="pair-inner card">
        <div class="pair-cell-border pair-cook-border">
            <div id="cook-<?php echo $pair->getId(); ?>" class="<?= $this->e($course_class)?> pair-cook pair-cell">
                <?php echo $cook->getName(); ?>
                <span class="food-pref">
                    <?php $this->insert('html-team-food-pref-img', ['team' => $cook])?>
                </span>
            </div>
        </div>

        <div class="pair-cell-border pair-guest1-border">
            <div id="guest1-<?php echo $pair->getId(); ?>" class="<?= $this->e($course_class)?> pair-guest1 pair-guest pair-cell">
                <?php echo $pair->getGuest1()->getName(); ?>
                <span class="food-pref">
                    <?php $this->insert('html-team-food-pref-img', ['team' => $guest1])?>
                </span>
            </div>
        </div>

        <div class="pair-cell-border pair-guest2-border">
            <div id="guest2-<?php echo $pair->getId(); ?>" class="<?= $this->e($course_class)?> pair-guest2 pair-guest pair-cell">
                <?php echo $pair->getGuest2()->getName(); ?>
                <span class="food-pref">
                    <?php $this->insert('html-team-food-pref-img', ['team' => $guest2])?>
                </span>
            </div>
        </div>
    </div>
</td>
