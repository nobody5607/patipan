<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Dbupdate */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Update Command');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">
    <div class="box-header">
         <i class="fa fa-wrench"></i> <?=  Html::encode($this->title) ?> 
         <div class="pull-right">
             <?= Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['dbupdate/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-dbupdate']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['dbupdate/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-dbupdate', 'disabled'=>false]) 
             ?>
         </div>
    </div>
<div class="box-body">    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'dbupdate-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'dbupdate-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['dbupdate/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-dbupdate']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['dbupdate/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-dbupdate', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionDbupdateIds'
		],
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:40px;text-align: center;'],
	    ],
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],
            'name',
            'sql:ntext',
            [
                'format'=>'raw',
                'attribute'=>'status',
                'value'=> function ($model){
                    $str ="";
                    if($model->status == 1){
                        $str .= "<label class='label label-success'>Success</label>";
                    }else{
                        $str .= "<label class='label label-warning'>Wait</label>";
                    }
                    return $str;
                }
            ],
            'create_date',
            'create_by',
            // 'update_date',
            // 'update_by',
            // 'rstat',

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:180px;text-align: center;'],
		'template' => '{update} {delete}',
                'buttons'=>[
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('app', 'Edit'), 
                                    yii\helpers\Url::to(['dbupdate/update/'.$model->id]), [
                                    'title' => Yii::t('app', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'Delete'), 
                                yii\helpers\Url::to(['dbupdate/delete/'.$model->id]), [
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
    'id' => 'modal-dbupdate',
    //'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-dbupdate').on('click', function() {
    modalDbupdate($(this).attr('data-url'));
});

$('#modal-delbtn-dbupdate').on('click', function() {
    selectionDbupdateGrid($(this).attr('data-url'));
});

$('#dbupdate-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#dbupdate-grid').yiiGridView('getSelectedRows');
	disabledDbupdateBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledDbupdateBtn(key.length);
});

$('#dbupdate-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalDbupdate('<?= Url::to(['dbupdate/update', 'id'=>''])?>'+id);
});	

$('#dbupdate-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalDbupdate(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#dbupdate-grid-pjax'});
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

function disabledDbupdateBtn(num) {
    if(num>0) {
	$('#modal-delbtn-dbupdate').attr('disabled', false);
    } else {
	$('#modal-delbtn-dbupdate').attr('disabled', true);
    }
}

function selectionDbupdateGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionDbupdateIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#dbupdate-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalDbupdate(url) {
    $('#modal-dbupdate .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-dbupdate').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>