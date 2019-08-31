<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StockCategory */

$this->title = Yii::t('brand', 'Update {modelClass}: ', [
    'modelClass' => 'Stock Category',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('brand', 'Stock Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-category-update">

    <?= $this->render('_form', [
        'model' => $model,
        'mainCateGory'=>$mainCateGory
    ]) ?>

</div>
