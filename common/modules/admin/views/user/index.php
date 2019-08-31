<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel mdm\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'ผู้ใช้');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-title">
                    <i class="fa fa-user"></i> <?= Html::encode($this->title); ?>
                    <div class="pull-right">
                        <a href="<?= \yii\helpers\Url::to(['/admin/user/create'])?>" class="btn btn-success" style="color:#fff;"><i class="fa fa-plus"></i> เพิ่มผู้ใช้</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <div class="box-body"> 

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'headerOptions' => ['style' => 'width:50px'],
                    'class' => 'yii\grid\SerialColumn'
                ],
                [
                    'headerOptions' => ['style' => 'width:180px'],
                    'attribute'=>'email',
                    'value'=>function($model){
                        return isset($model->email)?$model->email:'';
                    }
                ],
                [
                    'headerOptions' => ['style' => 'width:100px'],
                    'attribute'=>'firstname',
                    'value'=>function($model){
                        return isset($model->profile->firstname)?$model->profile->firstname:'';
                    }
                ],
                [
                    'headerOptions' => ['style' => 'width:100px'],
                    'attribute'=>'lastname',
                    'value'=>function($model){
                        return isset($model->profile->lastname)?$model->profile->lastname:'';
                    }
                ],
                [
                    'headerOptions' => ['style' => 'width:100px'],
                    'attribute'=>'tel',
                    'value'=>function($model){
                        return isset($model->profile->tel)?$model->profile->tel:'';
                    }
                ],        
                [
                    'label'=>'สมัครเมื่อ',
                    'headerOptions' => ['style' => 'width:100px'],
                    'attribute'=>'created_at',
                    'value'=>function($model){
                        return isset($model->create_date)?appxq\sdii\utils\SDdate::mysql2phpDate($model->create_date):'';
                    }
                ],
                     
                
                ['class' => 'yii\grid\ActionColumn',
                    'header' => Yii::t('user', 'Manage'),
                    'template' => '{update} {delete} {verified}',
                    'headerOptions' => ['style' => 'width:100px'],
                    'buttons' => [
                        'update' => function ($url, $model) {
                            
                                return Html::a('<span class="fa fa-edit"></span> ' . Yii::t('chanpan', 'Edit'), yii\helpers\Url::to(['/user/admin/update-profile', 'id' => $model->id]), [
                                            'title' => Yii::t('chanpan', 'Edit'),
                                            'class' => 'btn btn-warning btn-xs',
                                            'data-action' => 'update',
                                            'id' => "update{$model['id']}"
                                ]);
                        },
                        'block' => function ($url, $model) {
                            if ($model->id != Yii::$app->user->getId()) {
                                if ($model->isBlocked) {
                                    return Html::a(Yii::t('user', 'Allow [Off]'), ['block', 'id' => $model->id], [
                                                'class' => 'btn btn-xs btn-danger',
                                                'data-method' => 'post',
                                                'data-action' => 'unblock',
                                                'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?')
                                    ]);
                                } else {
                                    return Html::a(Yii::t('user', 'Allow [On]'), ['block', 'id' => $model->id], [
                                                'class' => 'btn btn-xs btn-success',
                                                'data-method' => 'post',
                                                'data-action' => 'block',
                                                'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?')
                                    ]);
                                }
                            }
                        },
                        'delete' => function ($url, $model) {
                                if ($model->id != Yii::$app->user->getId()) {
                                    return Html::a('<span class="fa fa-trash"></span> ' . Yii::t('chanpan', 'Delete'), $url, [
                                                'title' => Yii::t('chanpan', 'Delete'),
                                                'class' => 'btn btn-danger btn-xs',
                                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                'data-method' => 'post',
                                                'data-action' => 'delete',
                                                'id' => "delete{$model['id']}"
                                    ]);
                                }
                        }
                    ],
                    'contentOptions' => ['style' => 'width:160px;text-align:left;']
                ],
            ],
        ]);
        ?>
    </div>
