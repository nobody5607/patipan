<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StockProductDocs */

$this->title = Yii::t('brand', 'Update {modelClass}: ', [
    'modelClass' => 'Stock Product Docs',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('brand', 'Stock Product Docs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-product-docs-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
