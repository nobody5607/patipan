<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\StockProductItems */

$this->title = 'Stock Product Items#'.$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('product', 'Stock Product Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-product-items-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'id',
		'group_id',
		'name',
		'icon',
		'size:ntext',
		'weight:ntext',
		'price',
		'price_update',
	    ],
	]) ?>
    </div>
</div>
