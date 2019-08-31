<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Skin */

$this->title = 'Skin#'.$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Skins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skin-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'id',
		'name',
		'value',
		'default',
	    ],
	]) ?>
    </div>
</div>
