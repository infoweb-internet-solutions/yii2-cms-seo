<?php

?>
<div class="tab-content language-tab">
    <?= $form->field($tags['title']->translate($language), 'value')->textArea([
        'rows' => 5,
        'name' => "title[{$language}]",
    ])->label($tags['title']->label); ?>
    
    <?= $form->field($tags['description']->translate($language), 'value')->textArea([
        'rows' => 5,
        'name' => "description[{$language}]",
    ])->label($tags['description']->label); ?>
    
    <?= $form->field($tags['keywords']->translate($language), 'value')->textArea([
        'rows' => 5,
        'name' => "keywords[{$language}]",
    ])->label($tags['keywords']->label); ?>
</div>