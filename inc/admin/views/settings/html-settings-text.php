<?php

use League\Plates\Template\Template;

/**
 * View to render a Text Settings Field
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var     Template        $this           Template Object.
 * @var     string          $label_for      Label ID and Name ID for the field
 * @var     string          $value          Value of the field.
 * @var     string          $description    Description of the field.
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<label for="<?= $this->e($label_for) ?>"></label>
<input id="<?= $this->e($label_for) ?>" name="<?= $this->e($label_for) ?>" type="text" value="<?= $this->e($value) ?>">

<?php if (isset($description)): ?>
    <p class="description">
        <?= $this->e($description) ?>
    </p>
<?php endif; ?>