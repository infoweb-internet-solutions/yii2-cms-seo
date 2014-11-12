<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SeoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('infoweb/seo', 'Seo');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-index">

    <?php // Title ?>
    <h1>
        <?= Html::encode($this->title) ?>
        <?php // Buttons ?>
        <div class="pull-right">
            <?php if (Yii::$app->user->can('Superadmin')) : ?>
            <?= Html::a(Yii::t('app', 'Create {modelClass}', [
                'modelClass' => Yii::t('infoweb/seo', 'Seo'),
            ]), ['create'], ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
            <?= Html::a('<span class="fa fa-gear"></span>', ['settings'], ['class' => 'btn btn-default', 'title' => Yii::t('app', 'Settings')]) ?>
        </div>
    </h1>
    
    <?php // Flash messages ?>
    <?php echo $this->render('_flash_messages'); ?>

    <?php // Gridview ?>
    <?php Pjax::begin([
        'id'=>'grid-pjax'
    ]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'kartik\grid\DataColumn',
                'label' => Yii::t('app', 'Entity'),
                'value' => 'entityTypeName'
            ],
            [
                'class' => 'kartik\grid\DataColumn',
                'label' => Yii::t('app', 'Name'),
                'attribute' => 'entityModel.name',
                'value' => 'entityModel.name',
                'enableSorting' => true
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update}',
                'updateOptions' => ['title' => Yii::t('app', 'Update'), 'data-toggle' => 'tooltip'],
                'width' => '100px',
            ],
        ],
        'responsive' => true,
        'floatHeader' => true,
        'floatHeaderOptions' => ['scrollingTop' => 88],
        'hover' => true,
        'export' => false,
    ]); ?>

</div>
