<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = Yii::t('rbac-admin', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    $usernameField,
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}
$columns[] = [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:80px;text-align: center;'],
		'template' => '{view}',
                'buttons'=>[
                    'view'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('chanpan', 'Assign'), 
                                    yii\helpers\Url::to(['/admin/assignment/view', 'id'=>$model->id]), [
                                    'title' => Yii::t('chanpan', 'Edit'),
                                    'class' => 'btn btn-info btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    }
                ]
	    ];
?>
<div class="box box-primary">
    <div class="box-header"><i class="fa fa-cogs"></i> <?= Html::encode($this->title) ?></div>    
<div class="box-body"> 
    <?php Pjax::begin(); ?>
    <?=
    appxq\sdii\widgets\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]);
    ?>
    <?php Pjax::end(); ?>

</div>
</div>