<div class="tab-content language-tab">
    <?= $form->field($model, "[{$model->language}]title")->textInput([
        'maxlength' => 255,
        'name' => "SeoLang[{$model->language}][title]"
    ]); ?>
    
    <?= $form->field($model, "[{$model->language}]description")->textarea([
        'name' => "SeoLang[{$model->language}][description]",
    ]); ?>

    <?= $form->field($model, "[{$model->language}]keywords")->textarea([
        'name' => "SeoLang[{$model->language}][keywords]",
    ]); ?>
</div>