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

$this->title = Yii::t('brand', 'Stock Product Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header">
        <i class="fa fa-table"></i> <?= Html::encode($this->title) ?> 
        <div class="pull-right">
            <?=
            Html::button(SDHtml::getBtnAdd(), ['data-url' => Url::to(['stock-product-group/create']), 'class' => 'btn btn-success btn-sm', 'id' => 'modal-addbtn-stock-product-group']) . ' ' .
            Html::button(SDHtml::getBtnDelete(), ['data-url' => Url::to(['stock-product-group/deletes']), 'class' => 'btn btn-danger btn-sm', 'id' => 'modal-delbtn-stock-product-group', 'disabled' => false])
            ?>
        </div>
    </div>
    <div class="box-body">    

        <?php Pjax::begin(['id' => 'stock-product-group-grid-pjax']); ?>
        <?=
        GridView::widget([
            'id' => 'stock-product-group-grid',
            /* 	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['stock-product-group/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-stock-product-group']). ' ' .
              Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['stock-product-group/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-stock-product-group', 'disabled'=>true]), */
            'dataProvider' => $dataProvider, 
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'checkboxOptions' => [
                        'class' => 'selectionStockProductGroupIds'
                    ],
                    'headerOptions' => ['style' => 'text-align: center;'],
                    'contentOptions' => ['style' => 'width:40px;text-align: center;'],
                ],
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['style' => 'text-align: center;'],
                    'contentOptions' => ['style' => 'width:60px;text-align: center;'],
                ],
                [
                    //'format' => 'raw',
                    //'attribute' => 'type',
                    'label' => Yii::t('product', 'Brands'),
                    'value' => function($model) {
                        $brand = frontend\modules\products\classes\CNProducts::getBrandById($model['brand_id']);
                        return isset($brand['name']) ? $brand['name'] : '';
                       // \appxq\sdii\utils\VarDumper::dump($brand);
                    }
                ],
                [
                    //'format' => 'raw',
                    //'attribute' => 'type',
                    'label' => Yii::t('product', 'Categorys'),
                    'value' => function($model) {
                        $cates = frontend\modules\products\classes\CNProducts::getCategorys($model['category_id']);
                        return isset($cates['name']) ? $cates['name'] : '';
                       // \appxq\sdii\utils\VarDumper::dump($brand);
                    }
                ], 
                'name',
                [
                    'format' => 'raw',
                    'attribute' => 'filename',
                    'label' => Yii::t('product', 'Image'),
                    'contentOptions' => ['style' => 'width:250px;text-align:center;'],
                    'value' => function($model) {
                        $storageUrl = isset(Yii::$app->params['storageUrl']) ? Yii::$app->params['storageUrl'] : '';
                        $path = '/source/products/group/';
                        $pluginOptions = [];
                        $imageStr = '';
                        $model['icon'] = explode(',', $model['icon']);

                        foreach ($model['icon'] as $key => $v) {
                            $imageStr .= '<div class="col-md-4">';
                            $imageStr .= Html::img("{$storageUrl}{$path}{$v}", ['class' => 'img img-responsive']);
                            $imageStr .= '</div>';
                        }

                        return $imageStr;
                    }
                ],
                // 'description:ntext',
                // 'deleted',
                [
                    'class' => 'appxq\sdii\widgets\ActionColumn',
                    'contentOptions' => ['style' => 'width:80px;text-align: center;'],
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function($url, $model) {
                            return Html::a('<span class="fa fa-edit"></span> ' . Yii::t('chanpan', 'Edit'), yii\helpers\Url::to(['stock-product-group/update?id=' . $model->id]), [
                                        'title' => Yii::t('chanpan', 'Edit'),
                                        'class' => 'btn btn-warning btn-xs',
                                        'data-action' => 'update',
                                        'data-pjax' => 0
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="fa fa-trash"></span> ' . Yii::t('chanpan', 'Delete'), yii\helpers\Url::to(['stock-product-group/delete?id=' . $model->id]), [
                                        'title' => Yii::t('chanpan', 'Delete'),
                                        'class' => 'btn btn-danger btn-xs',
                                        'data-confirm' => Yii::t('chanpan', 'Are you sure you want to delete this item?'),
                                        'data-method' => 'post',
                                        'data-action' => 'delete',
                                        'data-pjax' => 0
                            ]);
                        },
                    ]
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>

    </div>
</div>
        <?=
        ModalForm::widget([
            'id' => 'modal-stock-product-group',
            'size' => 'modal-lg',
        ]);
        ?>

<?php
\richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]);
?>
<script>
// JS script
    $('#modal-addbtn-stock-product-group').on('click', function () {
        modalStockProductGroup($(this).attr('data-url'));
    });

    $('#modal-delbtn-stock-product-group').on('click', function () {
        selectionStockProductGroupGrid($(this).attr('data-url'));
    });

    $('#stock-product-group-grid-pjax').on('click', '.select-on-check-all', function () {
        window.setTimeout(function () {
            var key = $('#stock-product-group-grid').yiiGridView('getSelectedRows');
            disabledStockProductGroupBtn(key.length);
        }, 100);
    });

    $('.selectionCoreOptionIds').on('click', function () {
        var key = $('input:checked[class=\"' + $(this).attr('class') + '\"]');
        disabledStockProductGroupBtn(key.length);
    });

    $('#stock-product-group-grid-pjax').on('dblclick', 'tbody tr', function () {
        var id = $(this).attr('data-key');
        modalStockProductGroup('<?= Url::to(['stock-product-group/update', 'id' => '']) ?>' + id);
    });

    $('#stock-product-group-grid-pjax').on('click', 'tbody tr td a', function () {
        var url = $(this).attr('href');
        var action = $(this).attr('data-action');

        if (action === 'update' || action === 'view') {
            modalStockProductGroup(url);
        } else if (action === 'delete') {
            yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?') ?>', function () {
                $.post(
                        url
                        ).done(function (result) {
                    if (result.status == 'success') {
<?= SDNoty::show('result.message', 'result.status') ?>
                        $.pjax.reload({container: '#stock-product-group-grid-pjax'});
                    } else {
<?= SDNoty::show('result.message', 'result.status') ?>
                    }
                }).fail(function () {
<?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"') ?>
                    console.log('server error');
                });
            });
        }
        return false;
    });

    function disabledStockProductGroupBtn(num) {
        if (num > 0) {
            $('#modal-delbtn-stock-product-group').attr('disabled', false);
        } else {
            $('#modal-delbtn-stock-product-group').attr('disabled', true);
        }
    }

    function selectionStockProductGroupGrid(url) {
        yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?') ?>', function () {
            $.ajax({
                method: 'POST',
                url: url,
                data: $('.selectionStockProductGroupIds:checked[name=\"selection[]\"]').serialize(),
                dataType: 'JSON',
                success: function (result, textStatus) {
                    if (result.status == 'success') {
<?= SDNoty::show('result.message', 'result.status') ?>
                        $.pjax.reload({container: '#stock-product-group-grid-pjax'});
                    } else {
<?= SDNoty::show('result.message', 'result.status') ?>
                    }
                }
            });
        });
    }

    function modalStockProductGroup(url) {
        $('#modal-stock-product-group .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
        $('#modal-stock-product-group').modal('show')
                .find('.modal-content')
                .load(url);
    }
</script>
<?php \richardfan\widget\JSRegister::end(); ?>