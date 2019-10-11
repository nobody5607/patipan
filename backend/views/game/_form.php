<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $model backend\models\Test */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="test-form">

    <?php
    $form = ActiveForm::begin([
                'id' => $model->formName(),
    ]);
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="itemModalLabel"><i class="fa fa-gamepad"></i> จัดการเกมส์</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <?= $form->field($model, 'number')->hiddenInput()->label(false);?>
            <div class="col-md-6">
                <?php
                $items = \yii\helpers\ArrayHelper::map(backend\models\GameType::find()->all(), 'id', 'name');
                ?>
                <?= $form->field($model, 'type')->dropDownList($items, ['prompt' => '--เลือกประเภท--']) ?>
            </div>
            <div class="col-md-6">
                <?php
                echo $form->field($model, 'answer')->textInput();
                ?>
            </div>

        </div>
        <div class="row"> 
            <div class="col-md-12">
                <?php
                echo $form->field($model, 'question')->widget(\cpn\chanpan\widgets\CNFroalaEditorWidget::className(), [
                    'toolbar_size' => 'lg',
                    'options' => ['class' => 'question'],
                ])->label(false);
                ?>
            </div> 
        </div>




    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
<?= Html::submitButton('บันทึก', ['class' => 'btn btn-primary btn-lg btn-block']) ?>

            </div>
        </div>
    </div> 

<?php ActiveForm::end(); ?>

</div>

<?php
\richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]);
?>
<script>
// JS script
    $('form#<?= $model->formName() ?>').on('beforeSubmit', function (e) {
        var $form = $(this);
        $.post(
                $form.attr('action'), //serialize Yii2 form
                $form.serialize()
                ).done(function (result) {
            if (result.status == 'success') {
<?= SDNoty::show('result.message', 'result.status') ?>
                $(document).find('#modal-game').modal('hide');
                location.reload();
            } else {
<?= SDNoty::show('result.message', 'result.status') ?>
            }
        }).fail(function () {
<?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"') ?>
            console.log('server error');
        });
        return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end(); ?>