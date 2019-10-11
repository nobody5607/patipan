<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
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
<div class="box box-primary">
    <div class="box-header">
        <i class="fa fa-user"></i> <?=  Html::encode($this->title) ?>
        <div class="pull-right">
            <?= Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['student/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-student']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['student/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-student', 'disabled'=>false]) 
             ?>
        </div>
    </div>
    <div class="box-body">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php  Pjax::begin(['id'=>'student-grid-pjax']);?>
        <?= GridView::widget([
	'id' => 'student-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['student/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-student']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['student/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-student', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionStudentIds'
		],
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:40px;text-align: center;'],
	    ],
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],

            'id',
            'name',
            'number',
            'room',
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
            // 'address:ntext',
            // 'tel',
            // 'create_by',
            // 'create_date',
            // 'update_by',
            // 'update_date',
            // 'rstat',
            'start_score',
            'end_score',

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
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('app', 'แก้ไข'), 
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
                                'data-confirm' => Yii::t('chanpan', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-action' => 'delete',
                                'data-pjax'=>0
                        ]);
                            
                        
                    },
                ]
	    ],
        ],
    ]); ?>
        <?php  Pjax::end();?>

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
$('#modal-addbtn-student').on('click', function() {
    modalStudent($(this).attr('data-url'));
});

$('#modal-delbtn-student').on('click', function() {
    selectionStudentGrid($(this).attr('data-url'));
});

$('#student-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
        var key = $('#student-grid').yiiGridView('getSelectedRows');
        disabledStudentBtn(key.length);
    }, 100);
});

$('.selectionCoreOptionIds').on('click', function() {
    var key = $('input:checked[class=\"' + $(this).attr('class') + '\"]');
    disabledStudentBtn(key.length);
});

$('#student-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalStudent('<?= Url::to(['student/update', 'id'=>''])?>' + id);
});

$('#student-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if (action === 'update' || action === 'view') {
        modalStudent(url);
    } else if (action === 'delete') {
        yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
            $.post(
                url
            ).done(function(result) {
                if (result.status == 'success') {
                    <?= SDNoty::show('result.message', 'result.status')?>
                    $.pjax.reload({
                        container: '#student-grid-pjax'
                    });
                } else {
                    <?= SDNoty::show('result.message', 'result.status')?>
                }
            }).fail(function() {
                <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
                console.log('server error');
            });
        });
    }
    return false;
});

function disabledStudentBtn(num) {
    if (num > 0) {
        $('#modal-delbtn-student').attr('disabled', false);
    } else {
        $('#modal-delbtn-student').attr('disabled', true);
    }
}

function selectionStudentGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
        $.ajax({
            method: 'POST',
            url: url,
            data: $('.selectionStudentIds:checked[name=\"selection[]\"]').serialize(),
            dataType: 'JSON',
            success: function(result, textStatus) {
                if (result.status == 'success') {
                    <?= SDNoty::show('result.message', 'result.status')?>
                    $.pjax.reload({
                        container: '#student-grid-pjax'
                    });
                } else {
                    <?= SDNoty::show('result.message', 'result.status')?>
                }
            }
        });
    });
}

function modalStudent(url) {
    $('#modal-student .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-student').modal('show')
        .find('.modal-content')
        .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>
