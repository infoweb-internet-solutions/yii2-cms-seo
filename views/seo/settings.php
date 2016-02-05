<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

$this->title = Yii::t('app', 'Update {modelClass}', [
    'modelClass' => Yii::t('infoweb/seo', 'seo settings'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('infoweb/seo', 'Seo'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('infoweb/settings', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="seo-settings">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="seo-settings-form">

        <?php if (isset($errors)) : ?>
        <div class="alert alert-danger"><?php echo $errors; ?></div>    
        <?php endif; ?>
            
        <?php
        // Init the form
        $form = ActiveForm::begin([
            'id'                        => 'seo-settings-form',
            'options'                   => ['class' => 'tabbed-form'],
            'enableAjaxValidation'      => false,
            'enableClientValidation'    => false        
        ]);
    
        // Initialize the tabs
        $tabs = [];
        
        // Add the language tabs
        foreach (Yii::$app->params['languages'] as $languageId => $languageName) {
            $tabs[] = [
                'label' => $languageName,
                'content' => $this->render('_settings_tab', [
                    'tags' => $tags,
                    'form' => $form,
                    'language' => $languageId
                ]),
                'active' => ($languageId == Yii::$app->language) ? true : false
            ];
        } 
        
        // Display the tabs
        echo Tabs::widget(['items' => $tabs]);   
        ?>
    
        <div class="form-group buttons">
            <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    
    </div

</div>