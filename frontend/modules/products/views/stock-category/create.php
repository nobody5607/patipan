<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StockCategory */

$this->title = Yii::t('brand', 'Create Stock Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('brand', 'Stock Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-category-create">

    <?= $this->render('_form', [
        'model' => $model,
        'mainCateGory'=>$mainCateGory
    ]) ?>

</div>
