<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StockBrand */

$this->title = Yii::t('brand', 'Update {modelClass}: ', [
    'modelClass' => 'Stock Brand',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('brand', 'Stock Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-brand-update">

    <?= $this->render('_form', [
        'model' => $model,
        'mainBrands'=>$mainBrands
    ]) ?>

</div>
