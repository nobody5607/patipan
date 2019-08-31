<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StockProductDocs */

$this->title = Yii::t('brand', 'Create Stock Product Docs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('brand', 'Stock Product Docs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-product-docs-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
