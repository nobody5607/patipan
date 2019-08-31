<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\StockProductGroup */

$this->title = 'Stock Product Group#'.$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('brand', 'Stock Product Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-product-group-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'id',
		'brand_id',
		'category_id',
		'name',
		'icon',
		'description:ntext',
		'deleted',
	    ],
	]) ?>
    </div>
</div>
