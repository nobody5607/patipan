<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StockProductGroup */

$this->title = Yii::t('brand', 'Create Stock Product Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('brand', 'Stock Product Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-product-group-create">

    <?= $this->render('_form', [
        'model' => $model,
        'itemsChoices'=>$itemsChoices,
    ]) ?>

</div>
