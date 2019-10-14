<?php

use yii\helpers\Html;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Student */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'จัดการนักเรียน');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-9 col-xs-9 col-sm-9">
                <label><i class="fa fa-user"></i> <?= Html::encode($this->title) ?></label>
            </div>
            <div class="col-md-3 col-xs-3 col-sm-3 text-right">
                <?= Html::button('เพิ่มนักเรียน '.SDHtml::getBtnAdd(), [
                    'data-url'=>Url::to(['student/create']),
                    'class' => 'btn btn-success btn-xs',
                    'id'=>'modal-addbtn-student']);
                ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?= \kartik\grid\GridView::widget([
	'id' => 'student-grid',
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
            [
                    'contentOptions' => ['style'=>'wdith:50px;text-align:center'],
                    'attribute' => 'number',
                    'value' => function($model){
                        return isset($model->number)?$model->number:'';
                    }
            ],
            [

                'contentOptions' => ['style'=>'wdith:100px;text-align:center'],
                'attribute' => 'id',
                'value' => function($model){
                    return isset($model->id)?$model->id:'';
                }
            ],
            'name',
            [
                'format'=>'raw',
                'attribute'=>'sex',
                'value'=>function($model){
                    if(!isset($model->sex) || $model->sex == ''){return 'ไม่ระบุ';}
                    if($model->sex == 1){
                        return 'ชาย';
                    }else if($model->sex == 2){
                        return 'หญิง';
                    }
                    
                },
                'filter' => [ "1"=>"ชาย", "2"=>"หญิง" ]
            ],
            [

                'contentOptions' => ['style'=>'wdith:100px;text-align:center'],
                'label' => 'คะแนนเกมการบวก',
                'value' => function($model){
                    $player = \backend\models\Players::find()
                        ->where('type=1 AND user_id=:id',[
                                ':id' => $model->id
                        ])->orderBy(['scores'=>SORT_DESC])->one();
                    if($player){
                        return $player['scores'];
                    }
                    return 0;
                }
            ],
            [

                'contentOptions' => ['style'=>'wdith:100px;text-align:center'],
                'label' => 'คะแนนเกมการลบ',
                'value' => function($model){
                    $player = \backend\models\Players::find()
                        ->where('type=2 AND user_id=:id',[
                            ':id' => $model->id
                        ])->orderBy(['scores'=>SORT_DESC])->one();
                    if($player){
                        return $player['scores'];
                    }
                    return 0;
                }
            ],
            [

                'contentOptions' => ['style'=>'wdith:100px;text-align:center'],
                'label' => 'คะแนนเกมการคูณ',
                'value' => function($model){
                    $player = \backend\models\Players::find()
                        ->where('type=3 AND user_id=:id',[
                            ':id' => $model->id
                        ])->orderBy(['scores'=>SORT_DESC])->one();
                    if($player){
                        return $player['scores'];
                    }
                    return 0;
                }
            ],
            [

                'contentOptions' => ['style'=>'wdith:100px;text-align:center'],
                'label' => 'คะแนนเกมการหาร',
                'value' => function($model){
                    $player = \backend\models\Players::find()
                        ->where('type=4 AND user_id=:id',[
                            ':id' => $model->id
                        ])->orderBy(['scores'=>SORT_DESC])->one();
                    if($player){
                        return $player['scores'];
                    }
                    return 0;
                }
            ],


	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:250px;text-align: center;'],
		'template' => '{view} {update} {delete}',
                'buttons'=>[
                    'view'=>function($url, $model){
                        return Html::a('<span class="fa fa-eye"></span> '.Yii::t('app', 'View'), 
                                    yii\helpers\Url::to(['student/view?id='.$model->id]), [
                                    'title' => Yii::t('app', 'view'),
                                    'class' => 'btn btn-default btn-xs',
                                    'data-action'=>'view',
                                    'data-pjax'=>0
                        ]);
                    },
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-pencil"></span> '.Yii::t('app', 'แก้ไข'),
                                    yii\helpers\Url::to(['student/update?id='.$model->id]), [
                                    'title' => Yii::t('app', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'Delete'), 
                                yii\helpers\Url::to(['student/delete?id='.$model->id]), [
                                'title' => Yii::t('app', 'Delete'),
                                'class' => 'btn btn-danger btn-xs',
                                'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-action' => 'delete',
                                'data-pjax'=>0
                        ]);
                            
                        
                    },
                ]
	    ],
        ],
    ]); ?>
    </div>
</div>
<?=  ModalForm::widget([
    'id' => 'modal-student',
    //'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script

$( "td:eq(0)" ).addClass('iconTb text-center');
setTimeout(function(){
    $('.iconTb').html("<i title='ค้นหา' class='glyphicon glyphicon-search'></i>");
});

$('#modal-addbtn-student').on('click', function() {
    modalStudent($(this).attr('data-url'));
});


$('.kv-grid-table').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if (action === 'update' || action === 'view') {
        modalStudent(url);
    } else if (action === 'delete') {
        yii.confirm('<?= Yii::t('app', 'Are you sure you want to delete this item?')?>', function() {
            $.post(
                url
            ).done(function(result) {
                <?= SDNoty::show('result.message', 'result.status')?>
                location.reload();
            }).fail(function() {
                <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
                console.log('server error');
            });
        });
    }
    return false;
});

function modalStudent(url) {
    $('#modal-student .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-student').modal('show')
        .find('.modal-content')
        .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>
