<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Student */

$this->title = 'นักเรียน#'.$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'นักเรียน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-view">

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
		'number',
		'room',
		[
			'attribute'=>'sex',
			'value'=>function($model){
				if(!isset($model->sex) || $model->sex == ''){return 'ไม่ระบุ';}
				if($model->sex == 1){
					return 'ชาย';
				}else if($model->sex == 2){
					return 'หญิง';
				}
				
			}
		],
		
		'tel',
		[
			'attribute'=>'create_by',
			'value'=>function($model){
				$user = \common\modules\user\classes\CNUserFunc::getUserById($model->create_by);
				$fname = isset($user->profile->firstname)?$user->profile->firstname:'';
				$lname = isset($user->profile->lastname)?$user->profile->lastname:'';
				return "{$fname} {$lname}";
			}
		],
		'create_date',
		[
			'attribute'=>'update_by',
			'value'=>function($model){
				$user = \common\modules\user\classes\CNUserFunc::getUserById($model->create_by);
				$fname = isset($user->profile->firstname)?$user->profile->firstname:'';
				$lname = isset($user->profile->lastname)?$user->profile->lastname:'';
				return "{$fname} {$lname}";
			}
		],
		'update_date',
	    ],
	]) ?>
    </div>
</div>
