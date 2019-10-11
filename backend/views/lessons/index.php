<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Lessons */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'จัดการบทเรียน');
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-book"></i> <?= Html::encode($this->title) ?>
            <div class="pull-right">
                <?= Html::button(SDHtml::getBtnAdd(), ['data-url' => Url::to(['lessons/create']), 'class' => 'btn btn-success btn-sm', 'id' => 'modal-addbtn-lessons']) . ' ' .
                Html::button(SDHtml::getBtnDelete(), ['data-url' => Url::to(['lessons/deletes']), 'class' => 'btn btn-danger btn-sm', 'id' => 'modal-delbtn-lessons', 'disabled' => false])
                ?>
            </div>
        </div>
        <div class="box-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php Pjax::begin(['id' => 'lessons-grid-pjax']); ?>
            <?= GridView::widget([
                'id' => 'lessons-grid',
                /*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['lessons/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-lessons']). ' ' .
                              Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['lessons/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-lessons', 'disabled'=>true]),*/
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [

                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'width:60px;text-align: center;'],
                    ],

                    'name',
                    [
                        'contentOptions' => ['style' => 'width:80px;text-align:center;'],
                        'attribute' => 'section',
                        'value' => function ($model) {
                            return isset($model->section) ? $model->section : "";
                        }
                    ],
                    //'create_by',
                    // 'create_date',
                    // 'updat_by',
                    // 'update_date',
                    // 'rstat',

                    [
                        'class' => 'appxq\sdii\widgets\ActionColumn',
                        'contentOptions' => ['style' => 'width:180px;text-align: center;'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="fa fa-eye"></span> ' . Yii::t('app', 'แสดง'),
                                    yii\helpers\Url::to(['lessons/view?id=' . $model->id]), [
                                        'title' => Yii::t('app', 'แก้ไข'),
                                        'class' => 'btn btn-default btn-xs',
                                        'data-action' => 'view',
                                        'data-pjax' => 0
                                    ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<span class="fa fa-edit"></span> ' . Yii::t('app', 'แก้ไข'),
                                    yii\helpers\Url::to(['lessons/update?id=' . $model->id]), [
                                        'title' => Yii::t('app', 'Edit'),
                                        'class' => 'btn btn-primary btn-xs',
                                        'data-action' => 'update',
                                        'data-pjax' => 0
                                    ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="fa fa-trash"></span> ' . Yii::t('app', 'ลบ'),
                                    yii\helpers\Url::to(['lessons/delete?id=' . $model->id]), [
                                        'title' => Yii::t('app', 'Delete'),
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
            ]); ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
<?= ModalForm::widget([
    'id' => 'modal-lessons',
    'size' => 'modal-lg',
]);
?>

<?php \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
    <script>
        $( "td:eq(0)" ).addClass('iconTb text-center');
        setTimeout(function(){
            $('.iconTb').html("<i title='ค้นหา' class='glyphicon glyphicon-search'></i>");
        });

        // JS script
        $('#modal-addbtn-lessons').on('click', function () {
            modalLesson($(this).attr('data-url'));
        });

        $('#modal-delbtn-lessons').on('click', function () {
            selectionLessonGrid($(this).attr('data-url'));
        });

        $('#lessons-grid-pjax').on('click', '.select-on-check-all', function () {
            window.setTimeout(function () {
                var key = $('#lessons-grid').yiiGridView('getSelectedRows');
                disabledLessonBtn(key.length);
            }, 100);
        });

        $('.selectionCoreOptionIds').on('click', function () {
            var key = $('input:checked[class=\"' + $(this).attr('class') + '\"]');
            disabledLessonBtn(key.length);
        });

        $('#lessons-grid-pjax').on('dblclick', 'tbody tr', function () {
            var id = $(this).attr('data-key');
            modalLesson('<?= Url::to(['lessons/update', 'id' => ''])?>' + id);
        });

        $('#lessons-grid-pjax').on('click', 'tbody tr td a', function () {
            var url = $(this).attr('href');
            var action = $(this).attr('data-action');

            if (action === 'update' || action === 'view') {
                modalLesson(url);
            } else if (action === 'delete') {
                yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function () {
                    $.post(
                        url
                    ).done(function (result) {
                        if (result.status == 'success') {
                            <?= SDNoty::show('result.message', 'result.status')?>
                            $.pjax.reload({container: '#lessons-grid-pjax'});
                        } else {
                            <?= SDNoty::show('result.message', 'result.status')?>
                        }
                    }).fail(function () {
                        <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
                        console.log('server error');
                    });
                });
            }
            return false;
        });

        function disabledLessonBtn(num) {
            if (num > 0) {
                $('#modal-delbtn-lessons').attr('disabled', false);
            } else {
                $('#modal-delbtn-lessons').attr('disabled', true);
            }
        }

        function selectionLessonGrid(url) {
            yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function () {
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: $('.selectionLessonIds:checked[name=\"selection[]\"]').serialize(),
                    dataType: 'JSON',
                    success: function (result, textStatus) {
                        if (result.status == 'success') {
                            <?= SDNoty::show('result.message', 'result.status')?>
                            $.pjax.reload({container: '#lessons-grid-pjax'});
                        } else {
                            <?= SDNoty::show('result.message', 'result.status')?>
                        }
                    }
                });
            });
        }

        function modalLesson(url) {
            $('#modal-lessons .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
            $('#modal-lessons').modal('show')
                .find('.modal-content')
                .load(url);
        }
    </script>
<?php \richardfan\widget\JSRegister::end(); ?>