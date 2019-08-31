<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TestChoice */

$this->title = 'Test Choice#'.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Test Choices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-choice-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'id',
		'test_id',
		'label',
		'value:ntext',
		'create_at',
		'create_date',
	    ],
	]) ?>
    </div>
</div>
