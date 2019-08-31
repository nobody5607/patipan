<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StockProductItems */

$this->title = Yii::t('product', 'Update {modelClass}: ', [
    'modelClass' => 'Stock Product Items',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('product', 'Stock Product Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-product-items-update">

    <?= $this->render('_form', [
        'model' => $model,
        'productGroup'=>$productGroup
    ]) ?>

</div>
