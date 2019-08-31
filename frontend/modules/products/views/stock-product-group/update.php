<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StockProductGroup */

$this->title = Yii::t('brand', 'Update {modelClass}: ', [
    'modelClass' => 'Stock Product Group',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('brand', 'Stock Product Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-product-group-update">

    <?= $this->render('_form', [
        'model' => $model,
        'itemsChoices'=>$itemsChoices,
    ]) ?>

</div>
