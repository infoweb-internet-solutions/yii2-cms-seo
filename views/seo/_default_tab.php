<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
?>
<div class="tab-content default-tab">
    <?= $form->field($model, 'entity')->dropDownList(['page' => Yii::t('infoweb/pages', 'Page')]); ?>
    
    <?= $form->field($model, 'entity_id')->dropDownList(ArrayHelper::map($entities['pages'], 'id', 'name')); ?>
</div>