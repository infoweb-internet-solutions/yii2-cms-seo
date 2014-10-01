<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Seo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seo-form">

    <div class="form-group">&nbsp;</div>

    <div class="form-group field-seo-entity">
        <label class="control-label" for="entity">Entity</label>
        <?= Html::dropDownList('Seo[entity]', $model->entity, $entities, ['class' => 'form-control', 'prompt' => 'Kies een entity']) ?>
        <div class="help-block"></div>
    </div>

    <div class="form-group field-seo-entity_id attribute entity_id-attribute">
        <label for="seo-entity_id" class="control-label"><?= Yii::t('app', 'Page'); ?></label>
        <?= Html::dropDownList('Seo[entity_id]', $model->entity_id, $pages, ['class' => 'form-control', 'id' => 'seo-entity_id', 'prompt' => Yii::t('app', 'Choose a page')]) ?>
        <div class="help-block"></div>
    </div>

</div>
