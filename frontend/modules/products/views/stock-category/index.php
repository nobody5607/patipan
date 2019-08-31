<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;
use Yii;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\products\models\StockCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('brand', 'Stock Categories');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">
    <div class="box-header">
         <i class="fa fa-table"></i> <?=  Html::encode($this->title) ?> 
         <div class="pull-right">
             <?= Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['stock-category/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-stock-category']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['stock-category/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-stock-category', 'disabled'=>false]) 
             ?>
         </div>
    </div>
<div class="box-body">    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  Pjax::begin(['id'=>'stock-category-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'stock-category-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['stock-category/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-stock-category']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['stock-category/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-stock-category', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
        'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionStockCategoryIds'
		],
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:40px;text-align: center;'],
	    ],
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],

//            'category_id',
            'name',
            [
                    'format' => 'raw',
                    'attribute' => 'type',
                    'label' => Yii::t('category', 'Category Type'),
                    'value' => function($model) {
                        $items = \appxq\sdii\utils\SDUtility::string2Array(isset(\Yii::$app->params['category_types']) ? \Yii::$app->params['category_types'] : '');
                        return $items[$model['type']]; 
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'icon',
                    'label' => Yii::t('category', 'Logo'),
                    'contentOptions'=>['style'=>'width:150px;text-align:center;'],
                    'value' => function($model) {
                        $storageUrl = isset(Yii::$app->params['storageUrl']) ? Yii::$app->params['storageUrl'] : '';
                        $path = '/source/brand/';
                        return Html::img("{$storageUrl}/{$path}/{$model['icon']}", ['style' => 'width:100px;', 'class'=>'img img-responsive']);
                    }
                ],

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:80px;text-align: center;'],
		'template' => '{update} {delete}',
                'buttons'=>[
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-edit"></span> '.Yii::t('chanpan', 'Edit'), 
                                    yii\helpers\Url::to(['stock-category/update?id='.$model->id]), [
                                    'title' => Yii::t('chanpan', 'Edit'),
                                    'class' => 'btn btn-warning btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('chanpan', 'Delete'), 
                                yii\helpers\Url::to(['stock-category/delete?id='.$model->id]), [
                                'title' => Yii::t('chanpan', 'Delete'),
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
    'id' => 'modal-stock-category',
    'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('#modal-addbtn-stock-category').on('click', function() {
    modalStockCategory($(this).attr('data-url'));
});

$('#modal-delbtn-stock-category').on('click', function() {
    selectionStockCategoryGrid($(this).attr('data-url'));
});

$('#stock-category-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#stock-category-grid').yiiGridView('getSelectedRows');
	disabledStockCategoryBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledStockCategoryBtn(key.length);
});

$('#stock-category-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalStockCategory('<?= Url::to(['stock-category/update', 'id'=>''])?>'+id);
});	

$('#stock-category-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalStockCategory(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#stock-category-grid-pjax'});
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

function disabledStockCategoryBtn(num) {
    if(num>0) {
	$('#modal-delbtn-stock-category').attr('disabled', false);
    } else {
	$('#modal-delbtn-stock-category').attr('disabled', true);
    }
}

function selectionStockCategoryGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionStockCategoryIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
		    <?= SDNoty::show('result.message', 'result.status')?>
		    $.pjax.reload({container:'#stock-category-grid-pjax'});
		} else {
		    <?= SDNoty::show('result.message', 'result.status')?>
		}
	    }
	});
    });
}

function modalStockCategory(url) {
    $('#modal-stock-category .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-stock-category').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>