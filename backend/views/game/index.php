<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Game */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Games');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">
    <div class="box-header">
        <h3><i class="fa fa-gamepad"></i> <?=  Html::encode($this->title) ?></h3> 
         <div class="pull-right">
             <?= Html::button(SDHtml::getBtnAdd().'เพิ่มเกมส์', [
                 'data-url'=>Url::to(['game/create']), 
                 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-game']);
             ?>
         </div>
        <br/>
    </div>
<div class="box-body">    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'game-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'game-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['game/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-game']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['game/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-game', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],
            [
                
                'format'=>'raw',
                'attribute'=>'question',
                'value'=>function($model){
                    return isset($model->question)? $model->question:'';
                },
            ],
            [
                'contentOptions' => ['style'=>'width:180px;text-align: center;'],
                'format'=>'raw',
                'attribute'=>'answer',
                'value'=>function($model){
                    return isset($model->answer)? $model->answer:'';
                },
            ],     
            //'create_by',
            // 'create_date',
            // 'update_by',
            // 'update_date',
            // 'type',

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:180px;text-align: center;'],
		'template' => '{update} {delete}',
                'buttons'=>[
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('app', 'แก้ไข'), 
                                    yii\helpers\Url::to(['update?id='.$model->id]), [
                                    'title' => Yii::t('app', 'แก้ไข'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'ลบ'), 
                                yii\helpers\Url::to(['delete?id='.$model->id]), [
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
    'id' => 'modal-game',
    //'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-game').on('click', function() {
    modalGame($(this).attr('data-url'));
});

$('#modal-delbtn-game').on('click', function() {
    selectionGameGrid($(this).attr('data-url'));
});

$('#game-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#game-grid').yiiGridView('getSelectedRows');
	disabledGameBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledGameBtn(key.length);
});

$('#game-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalGame('<?= Url::to(['game/update', 'id'=>''])?>'+id);
});	

$('#game-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalGame(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#game-grid-pjax'});
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

function disabledGameBtn(num) {
    if(num>0) {
	$('#modal-delbtn-game').attr('disabled', false);
    } else {
	$('#modal-delbtn-game').attr('disabled', true);
    }
}

function selectionGameGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionGameIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#game-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalGame(url) {
    $('#modal-game .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-game').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>