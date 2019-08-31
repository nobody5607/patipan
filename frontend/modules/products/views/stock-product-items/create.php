<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StockProductItems */

$this->title = Yii::t('product', 'Create Stock Product Items');
$this->params['breadcrumbs'][] = ['label' => Yii::t('product', 'Stock Product Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-product-items-create">

    <?= $this->render('_form', [
        'model' => $model,
        'productGroup'=>$productGroup
    ]) ?>

</div>
