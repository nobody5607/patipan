<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Dbupdate */

$this->title = 'Dbupdate#'.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dbupdates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dbupdate-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'id',
		'sql:ntext',
		'status',
		'create_date',
		'create_by',
		'update_date',
		'update_by',
		'rstat',
	    ],
	]) ?>
    </div>
</div>
