<?php
use League\Plates\Template\Template;

/**
 * View to render a fancy text field.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var     Template    $this      Template Object to render
 * @var     string      $label     Label for Field
 * @var     string      $name      Name for Field
 * @var     string      $type      Type of Field
 * @var     string      $value     Value of Field
 */
?>

<div class="kr_form_text">
    <label class="kr_label_text" for="<?= $this->e($name) ?>">
        <span><?= $this->e($label) ?></span>
    </label>
    <input class="kr_input_text" type="<?= isset($type) ? $type : 'text' ?>" id="<?= $this->e($name) ?>" name="<?= $this->e($name) ?>" <?php if (isset($value)) echo sprintf('value="%s"', $value) ?> required/>
</div>
