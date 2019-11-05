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

$this->title = Yii::t('app', 'จัดการเกม');
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <label><i class="fa fa-gamepad"></i> <?= Html::encode($this->title) ?></label>
            <div class="pull-right">
                <?= Html::button(SDHtml::getBtnAdd() . 'เพิ่มเกม', [
                    'data-url' => Url::to(['game/create']),
                    'class' => 'btn btn-success btn-sm', 'id' => 'modal-addbtn-game']);
                ?>
            </div>
            <br/>
        </div>
        <div class="panel-body">
            <?= GridView::widget([
                'id' => 'game-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'width:60px;text-align: center;'],
                    ],
                    [

                        'format' => 'raw',
                        'attribute' => 'question',
                        'value' => function ($model) {
                            return isset($model->question) ? $model->question : '';
                        },
                    ],
                    [
                        'contentOptions' => ['style' => 'width:180px;text-align: center;'],
                        'format' => 'raw',
                        'attribute' => 'answer',
                        'value' => function ($model) {
                            return isset($model->answer) ? $model->answer : '';
                        },
                    ],
                    [
                        'class' => 'appxq\sdii\widgets\ActionColumn',
                        'contentOptions' => ['style' => 'width:180px;text-align: center;'],
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<span class="fa fa-pencil"></span> ' . Yii::t('app', 'แก้ไข'),
                                    yii\helpers\Url::to(['update?id=' . $model->id]), [
                                        'title' => Yii::t('app', 'แก้ไข'),
                                        'class' => 'btn btn-primary btn-xs',
                                        'data-action' => 'update',
                                        'data-pjax' => 0
                                    ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="fa fa-trash"></span> ' . Yii::t('app', 'ลบ'),
                                    yii\helpers\Url::to(['delete?id=' . $model->id]), [
                                        'title' => Yii::t('app', 'ลบ'),
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
    'id' => 'modal-game',
    //'size'=>'modal-lg',
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
        $('#modal-addbtn-game').on('click', function () {
            modalGame($(this).attr('data-url'));
        });
        $('.table').on('click', 'tbody tr td a', function () {
            var url = $(this).attr('href');
            var action = $(this).attr('data-action');

            if (action === 'update' || action === 'view') {
                modalGame(url);
            } else if (action === 'delete') {
                bootbox.confirm({
                    message: '<?= Yii::t('app', 'Are you sure you want to delete this item?')?>',
                    buttons: {
                        confirm: {
                            label: 'ใช่',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'ไม่ใช่',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if(result === true){
                            $.post(
                                url
                            ).done(function (result) {
                                <?= SDNoty::show('result.message', 'result.status')?>
                                location.reload();
                            }).fail(function () {
                                <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
                                console.log('server error');
                            });
                        }
                    }
                });

            }
            return false;
        });


        function modalGame(url) {
            $('#modal-game .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
            $('#modal-game').modal('show')
                .find('.modal-content')
                .load(url);
        }
    </script>
<?php \richardfan\widget\JSRegister::end(); ?>