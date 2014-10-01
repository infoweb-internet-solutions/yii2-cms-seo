<div class="form-group">&nbsp;</div>

<input type="hidden" name="<?php echo $language; ?>[SeoLang][language]" value="<?php echo $language; ?>">

<?= $form->field($model, 'title')->textInput([
    'maxlength' => 255,
    'name' => "{$language}[SeoLang][title]",
    'id' => "title-{$language}",
]); ?>

<?= $form->field($model, 'description')->textarea([
    'name' => "{$language}[SeoLang][description]",
    'id' => "{$language}[SeoLang][description]",
]); ?>