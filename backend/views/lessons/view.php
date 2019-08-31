<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Lessons */

$this->title = 'บทเรียน#'.$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'บทเรียน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lessons-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'name',
		[
                    'format'=>'raw',
                    'attribute'=>'detail',
                    'value'=>function($model){
                        return isset($model->detail)?$model->detail:'';
                    }
                ],
		'section',
		[
			'attribute'=>'create_by',
			'value'=>function($model){
				$user = \common\modules\user\classes\CNUserFunc::getUserById($model->create_by);
				$fname = isset($user->profile->firstname)?$user->profile->firstname:'';
				$lname = isset($user->profile->lastname)?$user->profile->lastname:'';
				return "{$fname} {$lname}";
			}
		],
		//'update_by',
		'update_date',  
		
	    ],
	]) ?>
    </div>
</div>
