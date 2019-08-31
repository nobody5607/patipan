<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Systemlog */

$this->title = 'Systemlog#'.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systemlogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="systemlog-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'logname',
                        'logtype',
                        'logdetail:ntext',
                        'rstat',
                        'create_by',
                        'create_date',
                        'update_by',
                        'update_date',
                    ],
                ]) ?>
    </div>
</div>
