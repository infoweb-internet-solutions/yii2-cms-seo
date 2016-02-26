<?php
$tags['title']->translate($language);
$tags['description']->translate($language);
$tags['keywords']->translate($language);
?>
<div class="tab-content language-tab">
    <?= $form->field($tags['title'], 'value')->textArea([
        'rows' => 5,
        'name' => "title[{$language}]",
    ])->label($tags['title']->label); ?>
    
    <?= $form->field($tags['description'], 'value')->textArea([
        'rows' => 5,
        'name' => "description[{$language}]",
    ])->label($tags['description']->label); ?>
    
    <?= $form->field($tags['keywords'], 'value')->textArea([
        'rows' => 5,
        'name' => "keywords[{$language}]",
    ])->label($tags['keywords']->label); ?>
</div>