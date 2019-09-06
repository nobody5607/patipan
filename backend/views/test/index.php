<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Test */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'จัดการแบบทดสอบก่อนเรียน/หรือหลังเรียน');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">
    <div class="box-header">
         <i class="fa fa-file-o"></i> <?=  Html::encode($this->title) ?> 
         <div class="pull-right">
             <?= Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['test/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-test']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['test/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-test', 'disabled'=>false]) 
             ?>
         </div>
    </div>
<div class="box-body">    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'test-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'test-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['test/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-test']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['test/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-test', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionTestIds'
		],
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:40px;text-align: center;'],
	    ],
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],
            [
                'contentOptions'=>['style'=>'width:100px;text-align:right;'],
                'format'=>'raw',
                'attribute'=>'number',
                'value'=>function($model){
                    return isset($model->number) ? $model->number : '';
                }        
            ],  
            [
                'format'=>'raw',
                'attribute'=>'question',
                'value'=>function($model){
                    return isset($model->question)? $model->question:'';
                },
            ], 
             
            [
                'contentOptions'=>['style'=>'width:100px;text-align:right;'],
                'format'=>'raw',
                'attribute'=>'answer',
                'value'=>function($model){
                    return isset($model->answer) ? $model->answer : '';
                }, 
                'filter'=>['ก'=>'ก','ข'=>'ข','ค'=>'ค','ง'=>'ง']        
            ],             
            [
                'format'=>'raw',
                'attribute'=>'type',
                'value'=>function($model){
                    if(isset($model->type) && $model->type == 1){
                        return 'แบบทดสอบก่อนเรียน';
                    }
                    return 'แบบทดสอบหลังเรียน';
                },
                'filter' => ['1'=>'แบบทดสอบก่อนเรียน','2'=>'แบบทดสอบหลังเรียน']
            ],
            //'create_by',
            // 'create_date',
            // 'update_by',
            // 'update_date',

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:250px;text-align: center;'],
		'template' => '{view} {update} {delete}',
                'buttons'=>[
                    'view'=>function($url, $model){
                        return Html::a('<span class="fa"></span> '.Yii::t('app', 'เพิ่มคำตอบ'), 
                                    yii\helpers\Url::to(['test-choice/index?test_id='.$model->id]), [
                                    'title' => Yii::t('app', 'Edit'),
                                    'class' => 'btn btn-info btn-xs',
                                    'data-action'=>'answer',
                                    'data-pjax'=>0
                        ]);
                    },
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('app', 'แก้ไข'), 
                                    yii\helpers\Url::to(['test/update/'.$model->id]), [
                                    'title' => Yii::t('app', 'แก้ไข'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'ลบ'), 
                                yii\helpers\Url::to(['test/delete/'.$model->id]), [
                                'title' => Yii::t('app', 'ลบ'),
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
    'id' => 'modal-test',
    //'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-test').on('click', function() {
    modalTest($(this).attr('data-url'));
});

$('#modal-delbtn-test').on('click', function() {
    selectionTestGrid($(this).attr('data-url'));
});

$('#test-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#test-grid').yiiGridView('getSelectedRows');
	disabledTestBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledTestBtn(key.length);
});

$('#test-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalTest('<?= Url::to(['test/update', 'id'=>''])?>'+id);
});	

$('#test-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalTest(url);
    }else if(action === 'answer'){
//        location.href = url;
        window.open(url, '_blank');
    }else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#test-grid-pjax'});
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

function disabledTestBtn(num) {
    if(num>0) {
	$('#modal-delbtn-test').attr('disabled', false);
    } else {
	$('#modal-delbtn-test').attr('disabled', true);
    }
}

function selectionTestGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionTestIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#test-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalTest(url) {
    $('#modal-test .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-test').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>