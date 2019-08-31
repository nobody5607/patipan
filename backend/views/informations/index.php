<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Informations */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Informations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header">
        <i class="fa fa-table"></i> <?= Html::encode($this->title) ?> 
        <div class="pull-right">
            <?php if (Yii::$app->user->can('manage_information')): ?>
                <?=
                Html::button(SDHtml::getBtnAdd(), ['data-url' => Url::to(['informations/create']), 'class' => 'btn btn-success btn-sm', 'id' => 'modal-addbtn-informations']) . ' ' .
                Html::button(SDHtml::getBtnDelete(), ['data-url' => Url::to(['informations/deletes']), 'class' => 'btn btn-danger btn-sm', 'id' => 'modal-delbtn-informations', 'disabled' => false])
                ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="box-body">    
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php Pjax::begin(['id' => 'informations-grid-pjax']); ?>
        <?=
        GridView::widget([
            'id' => 'informations-grid',
            /* 	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['informations/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-informations']). ' ' .
              Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['informations/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-informations', 'disabled'=>true]), */
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'checkboxOptions' => [
                        'class' => 'selectionInformationIds'
                    ],
                    'headerOptions' => ['style' => 'text-align: center;'],
                    'contentOptions' => ['style' => 'width:40px;text-align: center;'],
                ],
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['style' => 'text-align: center;'],
                    'contentOptions' => ['style' => 'width:60px;text-align: center;'],
                ],
                'title',
                // 'create_by',
                // 'create_date',
                // 'update_by',
                // 'update_date',
                [
                    'class' => 'appxq\sdii\widgets\ActionColumn',
                    'contentOptions' => ['style' => 'width:80px;text-align: center;'],
                    'template' => '{view} {update} {delete}',
                    'buttons' => [
                        'update' => function($url, $model) {
                            if (Yii::$app->user->can('manage_information')) {
                                return Html::a('<span class="fa fa-edit"></span> ' . Yii::t('app', 'Edit'), yii\helpers\Url::to(['informations/update/' . $model->id]), [
                                            'title' => Yii::t('app', 'Edit'),
                                            'class' => 'btn btn-primary btn-xs',
                                            'data-action' => 'update',
                                            'data-pjax' => 0
                                ]);
                            }
                        },
                        'delete' => function ($url, $model) {
                            if (Yii::$app->user->can('manage_information')){
                                return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'Delete'),
                                yii\helpers\Url::to(['informations/delete/'.$model->id]), [
                                'title' => Yii::t('app', 'Delete'),
                                'class' => 'btn btn-danger btn-xs',
                                'data-confirm' => Yii::t('chanpan', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-action' => 'delete',
                                'data-pjax' => 0
                                ]);
                            }
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
        'id' => 'modal-informations',
            //'size'=>'modal-lg',
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
    $('#modal-addbtn-informations').on('click', function () {
        modalInformation($(this).attr('data-url'));
    });

    $('#modal-delbtn-informations').on('click', function () {
        selectionInformationGrid($(this).attr('data-url'));
    });

    $('#informations-grid-pjax').on('click', '.select-on-check-all', function () {
        window.setTimeout(function () {
            var key = $('#informations-grid').yiiGridView('getSelectedRows');
            disabledInformationBtn(key.length);
        }, 100);
    });

    $('.selectionCoreOptionIds').on('click', function () {
        var key = $('input:checked[class=\"' + $(this).attr('class') + '\"]');
        disabledInformationBtn(key.length);
    });

    $('#informations-grid-pjax').on('dblclick', 'tbody tr', function () {
        var id = $(this).attr('data-key');
        modalInformation('<?= Url::to(['informations/update', 'id' => '']) ?>' + id);
    });

    $('#informations-grid-pjax').on('click', 'tbody tr td a', function () {
        var url = $(this).attr('href');
        var action = $(this).attr('data-action');

        if (action === 'update' || action === 'view') {
            modalInformation(url);
        } else if (action === 'delete') {
            yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?') ?>', function () {
                $.post(
                        url
                        ).done(function (result) {
                    if (result.status == 'success') {
<?= SDNoty::show('result.message', 'result.status') ?>
                        $.pjax.reload({container: '#informations-grid-pjax'});
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

    function disabledInformationBtn(num) {
        if (num > 0) {
            $('#modal-delbtn-informations').attr('disabled', false);
        } else {
            $('#modal-delbtn-informations').attr('disabled', true);
        }
    }

    function selectionInformationGrid(url) {
        yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?') ?>', function () {
            $.ajax({
                method: 'POST',
                url: url,
                data: $('.selectionInformationIds:checked[name=\"selection[]\"]').serialize(),
                dataType: 'JSON',
                success: function (result, textStatus) {
                    if (result.status == 'success') {
<?= SDNoty::show('result.message', 'result.status') ?>
                        $.pjax.reload({container: '#informations-grid-pjax'});
                    } else {
<?= SDNoty::show('result.message', 'result.status') ?>
                    }
                }
            });
        });
    }

    function modalInformation(url) {
        $('#modal-informations .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
        $('#modal-informations').modal('show')
                .find('.modal-content')
                .load(url);
    }
</script>
<?php \richardfan\widget\JSRegister::end(); ?>