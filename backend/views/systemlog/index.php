<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Systemlog */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'System Logs');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">
    <div class="box-header">
         <i class="fa fa-wrench"></i> <?=  Html::encode($this->title) ?> 
         <div class="pull-right">
             <?= Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['systemlog/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-systemlog', 'disabled'=>false]) 
             ?>
         </div>
    </div>
<div class="box-body">    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'systemlog-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'systemlog-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['systemlog/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-systemlog']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['systemlog/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-systemlog', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionSystemlogIds'
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
                'contentOptions'=>['style'=>'width:150px'],
                'attribute'=>'logname',
                'value'=>function($model){ 
                    return isset($model->logname)?$model->logname:'ไม่ได้กำหนด';
                }
            ],
            [
                'format' => 'raw',
                'contentOptions'=>['style'=>'width:150px;'],
                'attribute' => 'logdetail',
                'value'=>function($model){
	                return "<div style='word-wrap:break-word;width:600px;'>{$model->logdetail}</div>";
                }
            ],
            [
                'contentOptions'=>['style'=>'width:100px'],
                'attribute'=>'logtype',
                'value'=>function($model){
                    if($model->logtype == 1){
                        return 'Log';
                    }
                    return 'Error';
                }
            ],      
            //'rstat',
//             [
//                    'attribute' => 'create_by',
//                    'value'=>function($model){
//	                    $name= 'Guest';
//	                    if(isset($model->create_by)){
//                            $user = \common\modules\user\classes\CNUserFunc::getUserById($model->create_by);
//                            $fname = isset($user->profile->firstname)?$user->profile->firstname:'';
//                            $lname = isset($user->profile->lastname)?$user->profile->lastname:'';
//                            if($fname || $lname){
//                                $name = "{$fname} {$lname}";
//                            }
//	                    }
//
//	                    return $name;
//                    }
//             ],
             [
                 'contentOptions'=>['style'=>'width:150px'],
                    'attribute' => 'create_date',
                    'value'=>function($model){
	                    $date = '';
	                    if(isset($model->create_date)){
                            $data = \appxq\sdii\utils\SDdate::mysql2phpDateTime($model->create_date);
                        }
	                    return $data;
                    }
             ],
            'ip',
            // 'update_by',
            // 'update_date',

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:80px;text-align: center;'],
		'template' => '{delete}',
                'buttons'=>[
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('app', 'Edit'), 
                                    yii\helpers\Url::to(['systemlog/update/'.$model->id]), [
                                    'title' => Yii::t('app', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'Delete'), 
                                yii\helpers\Url::to(['systemlog/delete/'.$model->id]), [
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
    'id' => 'modal-systemlog',
    'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-systemlog').on('click', function() {
    modalSystemlog($(this).attr('data-url'));
});

$('#modal-delbtn-systemlog').on('click', function() {
    selectionSystemlogGrid($(this).attr('data-url'));
});

$('#systemlog-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#systemlog-grid').yiiGridView('getSelectedRows');
	disabledSystemlogBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledSystemlogBtn(key.length);
});

$('#systemlog-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalSystemlog('<?= Url::to(['systemlog/view', 'id'=>''])?>'+id);
});	

$('#systemlog-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalSystemlog(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#systemlog-grid-pjax'});
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

function disabledSystemlogBtn(num) {
    if(num>0) {
	$('#modal-delbtn-systemlog').attr('disabled', false);
    } else {
	$('#modal-delbtn-systemlog').attr('disabled', true);
    }
}

function selectionSystemlogGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionSystemlogIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#systemlog-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalSystemlog(url) {
    $('#modal-systemlog .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-systemlog').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>