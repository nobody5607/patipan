<?php

use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
         
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
         
    ],
    [
        'attribute' => 'email',
        'label' => Yii::t('chanpan', 'Email'),
        'value' => 'email',
         
    ],
    [
        'attribute' => 'username',
        'value' => 'username',
        'headerOptions'=>['style'=>'width:10px']
    ],
    [
        'attribute' => 'firstname',
        'label' => Yii::t('chanpan', 'First name'),
        'value' => 'profile.firstname',
         
    ],
    [
        'attribute' => 'lastname',
        'label' => Yii::t('chanpan', 'Last name'),
        'value' => 'profile.lastname',
        
    ], 
    [
        'attribute' => 'created_at',
        'value' => function ($model) {
            if (extension_loaded('intl')) {
                return Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
            } else {
                return date('Y-m-d G:i:s', $model->created_at);
            }
        },
         
    ],
 [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'template'=>'{update} {delete}',
        'buttons'=>[
            'update' => function ($url, $model) {
                if (Yii::$app->user->can('admin')) {
                    return Html::a('<span class="fa fa-edit"></span> ' . Yii::t('chanpan', 'Edit'), yii\helpers\Url::to(['/user/admin/update-profile', 'id' => $model->id]), [
                            'title' => Yii::t('chanpan', 'Edit'),
                            'class' => 'btn btn-warning btn-xs',
                            'title'=>Yii::t('chanpan','Update'), 
                            'data-toggle'=>'tooltip',
                            'role'=>'modal-remote',
                    ]);
                }
            },
            'delete' => function ($url, $model) {
                    if (Yii::$app->user->can('admin')) {
                        if ($model->id != Yii::$app->user->getId()) {
                            return Html::a('<span class="fa fa-trash"></span> '.Yii::t('chanpan', 'Delete'), $url, 
                            [
                                'class'=>'btn btn-danger btn-xs',
                                'role'=>'modal-remote',
                                'title'=> Yii::t('chanpan','Delete'), 
                                'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                'data-request-method'=>'post',
                                'data-toggle'=>'tooltip',
                                'data-confirm-title'=>'Are you sure?',
                                'data-confirm-message'=>'Are you sure want to delete this item'           
                            ]);
                        }
                    }
            },          
        ],   
    ],
    
];

