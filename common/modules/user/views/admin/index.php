<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

$this->title = Yii::t('appmenu', 'จัดการครูผู้สอนคอมพิวเตอร์');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header">
        <div class="row">
            <div class="col-md-10">
                <div class="panel-title">
                    <i class="fa fa-user"></i> <?= Html::encode($this->title); ?>
                </div>
            </div>
            
        </div>
    </div>
    <div class="box-body">
        <div class="text-right">
            <button class="btn btn-success" id="btnCreate">เพิ่มครูผู้สอนคอมพิวเตอร์</button>
        </div>
<?php Pjax::begin(['id' => 'user-grid-pjax']); ?>
        <div>
        <?=
        GridView::widget([
            'id' => 'user-grid',
            //'panelBtn' => Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['/user/admin/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-user', 'disabled'=>true]),
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-bordered'],
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['style' => 'text-align: center;'],
                    'contentOptions' => ['style' => 'width:60px;text-align: center;'],
                ],
                [
                    'header' => Yii::t('_user', 'Admin'),
                    'value' => function ($model){
                        $data = \common\modules\user\classes\CNAuth::canAdmin($model->id);
                        if (!empty($data)) {
                            return '<i style="color:green;" class="glyphicon glyphicon-ok"></i>';
                        }
                        return '<i style="color:red;" class="glyphicon glyphicon-remove-sign"></i>';
                    },
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'text-align: center;'],
                    'contentOptions' => ['style' => 'width:90px;text-align: center;'],
                ],
                [
                    'contentOptions' => ['style' => 'width:150px;text-align: left;'],
                    'attribute' => 'username',
                    'value' => 'username',
                    'headerOptions' => ['style' => 'width:10px']
                ],
                [
                    'attribute' => 'firstname',
                    'label' => Yii::t('_user', 'First name'),
                    'value' => 'profile.firstname',
                ],
                [
                    'attribute' => 'lastname',
                    'label' => Yii::t('_user', 'Last name'),
                    'value' => 'profile.lastname',
                ],
                [
                    'attribute' => 'tel',
                    'label' => Yii::t('_user', 'Telephone number'),
                    'value' => 'profile.tel',
                ],            
                [
                    'attribute' => 'created_at',
                    'value' => function ($model) {
                        if (extension_loaded('intl')) {
                            $date = Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
                        } else {
                            $date = date('Y-m-d G:i:s', $model->created_at);
                            return appxq\sdii\utils\SDdate::mysql2phpDateTime($date);
                        }
                    },
                ],
                [
                    //'header' => 'Active',
                    'label'=>Yii::t('_user','Active'),
                    'value' => function ($model) {

                        if ($model->isConfirmed) {
                            return '<i style="color:green;" class="glyphicon glyphicon-ok"></i>';
                        } else {
                            return '<i style="color:red;" class="glyphicon " style="padding-right: 6px; padding-left: 6px;"></i>';
                        }
                    },
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'text-align: center;'],
                    'contentOptions' => ['style' => 'width:80px;text-align: center;'],
                ],
                [
                    'class' => 'appxq\sdii\widgets\ActionColumn',
                    'contentOptions' => ['style' => 'width:250px;text-align: center;'],
                    'template' => '{assign} {update} {delete} ',
                    ///admin/assignment/view?id=1
                    'buttons' => [
                        'assign' => function($url, $model) {
                            return Html::a('<span class="fa fa-shield"></span> ' . Yii::t('chanpan', 'มอบหมาย'), yii\helpers\Url::to(['/admin/assignment/view', 'id' => $model->id]), [
                                        'title' => Yii::t('user', 'Assign'),
                                        'class' => 'btn btn-success btn-xs',
                                        'data-action' => 'assign',
                                        'data-pjax' => 0
                            ]);
                        },
                        'update' => function($url, $model) {
                            return Html::a('<span class="fa fa-pencil"></span> ' . Yii::t('chanpan', 'แก้ไข'), yii\helpers\Url::to(['/user/admin/update-profile/', 'id' => $model->id]), [
                                        'title' => Yii::t('user', 'Edit'),
                                        'class' => 'btn btn-primary btn-xs',
                                        'data-action' => 'update',
                                        'data-pjax' => 0
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            if ($model->id != \Yii::$app->user->getId()) {
                                return Html::a('<span class="fa fa-trash"></span> ' . Yii::t('chanpan', 'Delete'), yii\helpers\Url::to(['/user/admin/delete/', 'id' => $model->id]), [
                                            'title' => Yii::t('chanpan', 'Delete'),
                                            'class' => 'btn btn-danger btn-xs',
                                            'data-confirm' => Yii::t('user', 'Are you sure you want to delete this item?'),
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
        </div>     
            <?php Pjax::end(); ?>
    </div>
</div>

            <?=
            ModalForm::widget([
                'id' => 'modal-user',
//    'size'=>'modal-lg',
                'options' => [
                ]
            ]);
            ?>

        <?php
        \richardfan\widget\JSRegister::begin([
            //'key' => 'bootstrap-modal',
            'position' => \yii\web\View::POS_READY
        ]);
        ?>
<script>
    $("#btnCreate").on('click', function(){
        const url = "<?= Url::to(['/user/admin/create'])?>";
        modalUser(url);
       return false;
    });
    //btnPreviewGraph
    $('.btnPreviewGraph').on('click', function () {
        modalUser($(this).attr('data-url'));
    });
// JS script
    $('#user-grid-pjax').on('click', '#modal-addbtn-user', function () {
        modalUser($(this).attr('data-url'));
    });

    $('#user-grid-pjax').on('click', '#modal-delbtn-user', function () {
        selectionUserGrid($(this).attr('data-url'));
    });

    $('#user-grid-pjax').on('click', '.select-on-check-all', function () {
        window.setTimeout(function () {
            var key = $('#user-grid').yiiGridView('getSelectedRows');
            disabledUserBtn(key.length);
        }, 100);
    });

    $('#user-grid-pjax').on('click', '.selectionUserIds', function () {
        var key = $('input:checked[class=\"' + $(this).attr('class') + '\"]');
        disabledUserBtn(key.length);
    });

    $('#user-grid-pjax').on('dblclick', 'tbody tr', function () {
        var id = $(this).attr('data-key');
        modalUser('<?= Url::to(['/user/admin/update-profile/', 'id' => '']) ?>' + id);
    });

    $('#user-grid-pjax').on('click', 'tbody tr td a', function () {
        var url = $(this).attr('href');
        var action = $(this).attr('data-action');

        if (action === 'update' || action === 'view') {
            modalUser(url);
        } else if (action === 'assign') {
            window.open(url, '_blank');
            return false;
        } else if (action === 'delete') {
            yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?') ?>', function () {
                $.post(
                        url
                        ).done(function (result) {
                    if (result.status == 'success') {
<?= SDNoty::show('result.message', 'result.status') ?>
                        $.pjax.reload({container: '#user-grid-pjax'});
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

    function disabledUserBtn(num) {
        if (num > 0) {
            $('#modal-delbtn-user').attr('disabled', false);
        } else {
            $('#modal-delbtn-user').attr('disabled', true);
        }
    }

    function selectionUserGrid(url) {
        yii.confirm('<?= Yii::t('app', 'Are you sure you want to delete these items?') ?>', function () {
            $.ajax({
                method: 'POST',
                url: url,
                data: $('.selectionUserIds:checked[name=\"selection[]\"]').serialize(),
                dataType: 'JSON',
                success: function (result, textStatus) {
                    if (result.status == 'success') {
<?= SDNoty::show('result.message', 'result.status') ?>
                        $.pjax.reload({container: '#user-grid-pjax'});
                    } else {
<?= SDNoty::show('result.message', 'result.status') ?>
                    }
                }
            });
        });
    }
    $('.btnAddUser').on('click', function () {
        let url = '<?= Url::to(['/user/admin/create']) ?>';
        modalUser(url);
        return false;
    });
    function modalUser(url) {
        $('#modal-user .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
        $('#modal-user').modal('show')
                .find('.modal-content')
                .load(url);
    }
</script>
<?php \richardfan\widget\JSRegister::end(); ?>


