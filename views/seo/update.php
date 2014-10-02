<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Seo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Seo',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Seo'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="seo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $items = [
        [
            'label' => 'General',
            'content' => $this->render('_form', [
                    'model' => $model,
                    'form' => $form,
                    'entities' => ['page' => 'page'],
                    'pages' => $pages,
            ]),
            'active' => true,
        ],
    ];

    // loop through languages to edit
    foreach (Yii::$app->params['languages'] as $k => $language) {

        $model->language = $k;
        $items[] = [
            'label' => $language,
            'content' => $this->render('_translation_item', ['model' => $model, 'language' => $k, 'form' => $form]),
        ];
    }
    ?>

    <?php
    echo Tabs::widget([
        'items' => $items,
    ]);
    ?>

    <div class="form-group">&nbsp;</div>

    <div class="buttons form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create & close') : Yii::t('app', 'Update & close'), ['class' => 'btn btn-default', 'name' => 'close']) ?>
        <?= Html::submitButton(Yii::t('app', $model->isNewRecord ? 'Create & new' : 'Update & new'), ['class' => 'btn btn-default', 'name' => 'new']) ?>
        <?= Html::a(Yii::t('app', 'Close'), ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
