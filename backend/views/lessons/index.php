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
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-9 col-xs-9 col-sm-9">
                    <label><i class="fa fa-book"></i> <?= Html::encode($this->title) ?></label>
                </div>
                <div class="col-md-3 col-xs-3 col-sm-3 text-right">
                    <?= Html::button('เพิ่มบทเรียน '.SDHtml::getBtnAdd(),
                        [
                            'data-url' => Url::to(['lessons/create']),
                            'class' => 'btn btn-success btn-xs',
                            'id' => 'modal-addbtn-lessons'
                        ])?>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


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
                                return Html::a('<span class="fa fa-pencil"></span> ' . Yii::t('app', 'แก้ไข'),
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


        $('.table').on('click', 'tbody tr td a', function () {
            var url = $(this).attr('href');
            var action = $(this).attr('data-action');

            if (action === 'update' || action === 'view') {
                modalLesson(url);
            } else if (action === 'delete') {
                yii.confirm('<?= Yii::t('app', 'Are you sure you want to delete this item?')?>', function () {
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


        function modalLesson(url) {
            $('#modal-lessons .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
            $('#modal-lessons').modal('show')
                .find('.modal-content')
                .load(url);
        }
    </script>
<?php \richardfan\widget\JSRegister::end(); ?>