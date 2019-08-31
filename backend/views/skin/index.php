<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Skins');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">
    <div class="box-header">
         <i class="fa fa-wrench"></i> <?=  Html::encode($this->title) ?> 
         <div class="pull-right">
             <?= Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['skin/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-skin']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['skin/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-skin', 'disabled'=>false]) 
             ?>
         </div>
    </div>
<div class="box-body">    

    <?php  Pjax::begin(['id'=>'skin-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'skin-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['skin/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-skin']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['skin/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-skin', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionSkinIds'
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
            'value',
            'default',

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:280px;text-align: center;'],
		'template' => '{default} {update} {delete}',
                'buttons'=>[
                    'default'=>function($url, $model){
                        return Html::a('<span class="fa fa-check"></span> '.Yii::t('app', 'Default'), 
                                    yii\helpers\Url::to(['skin/default?id='.$model->id]), [
                                    'title' => Yii::t('app', 'Default'),
                                    'class' => 'btn btn-info btn-xs',
                                    'data-action'=>'default',
                                    'data-pjax'=>0
                        ]);
                    },
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('app', 'Update'), 
                                    yii\helpers\Url::to(['skin/update?id='.$model->id]), [
                                    'title' => Yii::t('app', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'Delete'), 
                                yii\helpers\Url::to(['skin/delete?id='.$model->id]), [
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
    'id' => 'modal-skin',
    //'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-skin').on('click', function() {
    modalSkin($(this).attr('data-url'));
});

$('#modal-delbtn-skin').on('click', function() {
    selectionSkinGrid($(this).attr('data-url'));
});

$('#skin-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#skin-grid').yiiGridView('getSelectedRows');
	disabledSkinBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledSkinBtn(key.length);
});

$('#skin-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalSkin('<?= Url::to(['skin/update', 'id'=>''])?>'+id);
});	

$('#skin-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');
    if(action === 'default'){
        $.get(url, function(result){
            console.log(result);
            if(result.status == 'success') {
                <?= SDNoty::show('result.message', 'result.status') ?>
		    location.reload();
            } else {
                <?= SDNoty::show('result.message', 'result.status') ?>
            }
        });
        return false;
    }
    if(action === 'update' || action === 'view') {
	modalSkin(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#skin-grid-pjax'});
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

function disabledSkinBtn(num) {
    if(num>0) {
	$('#modal-delbtn-skin').attr('disabled', false);
    } else {
	$('#modal-delbtn-skin').attr('disabled', true);
    }
}

function selectionSkinGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionSkinIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#skin-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalSkin(url) {
    $('#modal-skin .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-skin').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>