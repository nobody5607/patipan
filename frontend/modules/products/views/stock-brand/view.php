<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\StockBrand */

$this->title = 'Stock Brand#'.$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('brand', 'Stock Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-brand-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'id',
		'type',
		'brand_id',
		'name',
		'icon',
		'description:ntext',
		'deleted',
	    ],
	]) ?>
    </div>
</div>
