<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StockBrand */

$this->title = Yii::t('brand', 'Update Stock Brand: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('brand', 'Stock Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('brand', 'Update');
?>
<div class="stock-brand-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
