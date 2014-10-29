<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Seo */

$this->title = Yii::t('app', 'Update {modelClass}', [
    'modelClass' => Yii::t('infoweb/seo', 'Seo'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('infoweb/seo', 'Seo'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "{$model->entityTypeName}: {$model->entityModel->name}", 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="seo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'entities' => $entities
    ]) ?>

</div>