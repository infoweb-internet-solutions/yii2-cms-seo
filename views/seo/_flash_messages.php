<?php if (Yii::$app->getSession()->hasFlash('seo')): ?>
<div class="alert alert-success">
    <p><?= Yii::$app->getSession()->getFlash('seo') ?></p>
</div>
<?php endif; ?>

<?php if (Yii::$app->getSession()->hasFlash('seo-error')): ?>
<div class="alert alert-danger">
    <p><?= Yii::$app->getSession()->getFlash('seo-error') ?></p>
</div>
<?php endif; ?>