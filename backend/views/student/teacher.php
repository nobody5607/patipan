<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml; 
 
$this->title = Yii::t('user', 'เพิ่มครูผู้สอนคอมพิวเตอร์');  
?>

 <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
    ]); ?>
     <?= $form->field($model, 'email')->textInput()?>
    <?= $form->field($model, 'username')->textInput()?>
    <?= $form->field($model, 'password')->textInput()?>
    <?= $form->field($model, 'confirmPassword')->textInput()?>
    <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'fname')->textInput()?></div>
        <div class="col-md-6"><?= $form->field($model, 'lname')->textInput()?></div>
    </div>
     
    <?= $form->field($model, 'tel')->textInput()?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
     
    var $form = $(this);
    $.post(
        $form.attr('action'), //serialize Yii2 form
        $form.serialize()
    ).done(function(result) {
        if(result.status == 'success') {
            <?= SDNoty::show('result.message', 'result.status')?>
            $(document).find('#modal-user').modal('hide');
            $.pjax.reload({container:'#user-grid-pjax'});
        } else {
            <?= SDNoty::show('result.message', 'result.status')?>
        } 
    }).fail(function() {
        <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
        console.log('server error');
    });
    return false;
});
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>