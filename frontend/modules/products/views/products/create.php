<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StockBrand */

$this->title = Yii::t('brand', 'Create Stock Brand');
$this->params['breadcrumbs'][] = ['label' => Yii::t('brand', 'Stock Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-brand-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
