<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TestChoice */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'คำตอบ');
$this->params['breadcrumbs'][] = $this->title;
$test_id = Yii::$app->request->get('test_id','');

?>
<div class="box box-primary">
    <div class="box-header">
         <i class="fa fa-table"></i> <?=  Html::encode($this->title) ?> 
         <div class="pull-right">
             <?= Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['create?test_id='.$test_id]), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-test-choice']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['test-choice/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-test-choice', 'disabled'=>false]) 
             ?>
         </div>
    </div>
<div class="box-body">    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'test-choice-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'test-choice-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['test-choice/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-test-choice']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['test-choice/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-test-choice', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionTestChoiceIds'
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
                'attribute'=>'label',
                'value'=>function($model){
                    return isset($model->label) ? $model->label : '';
                }, 
                'filter'=>['ก'=>'ก','ข'=>'ข','ค'=>'ค','ง'=>'ง']        
            ], 
            [
                'format'=>'raw',
                'attribute'=>'value',
                'value'=>function($model){
                    return isset($model->value) ? $model->value : '';
                }, 
            ], 
	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:180px;text-align: center;'],
		'template' => '{update} {delete}',
                'buttons'=>[
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('app', 'Edit'), 
                                    yii\helpers\Url::to(['test-choice/update?id='.$model->id]), [
                                    'title' => Yii::t('app', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'Delete'), 
                                yii\helpers\Url::to(['test-choice/delete?id='.$model->id]), [
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
    'id' => 'modal-test-choice',
    //'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-test-choice').on('click', function() {
    modalTestChoice($(this).attr('data-url'));
});

$('#modal-delbtn-test-choice').on('click', function() {
    selectionTestChoiceGrid($(this).attr('data-url'));
});

$('#test-choice-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#test-choice-grid').yiiGridView('getSelectedRows');
	disabledTestChoiceBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledTestChoiceBtn(key.length);
});

$('#test-choice-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalTestChoice('<?= Url::to(['test-choice/update', 'id'=>''])?>'+id);
});	

$('#test-choice-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalTestChoice(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#test-choice-grid-pjax'});
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

function disabledTestChoiceBtn(num) {
    if(num>0) {
	$('#modal-delbtn-test-choice').attr('disabled', false);
    } else {
	$('#modal-delbtn-test-choice').attr('disabled', true);
    }
}

function selectionTestChoiceGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionTestChoiceIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#test-choice-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalTestChoice(url) {
    $('#modal-test-choice .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-test-choice').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>