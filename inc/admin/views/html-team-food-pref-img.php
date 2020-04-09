<?php

use KitchenRun\Inc\Common\Model\Team;
use League\Plates\Template\Template;

/**
 * View to render Food Preference Icon of a team
 *
 * @since     1.0.0
 * @TODO      Improve Table Design.
 *
 * @author    Niklas Loos <niklas.loos@live.com>
 *
 * @var       Team      $team               Team Object
 * @var       Template  $this               Template Object to render this template
 */

$image_dir = "/wp-content/plugins/iswi-kitchen-run/assets/images/";
?>

<?php if ($team->getVegan()): ?>
    <img src="<?= $image_dir ?>leaf.png" alt="vegan" />
<?php elseif ($team->getVegetarian()): ?>
    <img src="<?= $image_dir ?>milk.png" alt="vegetarian" />
<?php elseif ($team->getHalal()): ?>
    <img src="<?= $image_dir ?>halal.png" alt="halal" />
<?php elseif ($team->getKosher()): ?>
    <img src="<?= $image_dir ?>kosher.png" alt="kosher" />
<?php else: ?>
    <img src="<?= $image_dir ?>beef.png" alt="everything" />
<?php endif; ?>

