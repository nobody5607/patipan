<?php
 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use appxq\sdii\helpers\SDHtml;
use appxq\sdii\helpers\SDNoty;
$this->title = Yii::t('chanpan', 'แก้ไข').' '.Yii::t('chanpan', 'ผู้ใช้');

$this->params['breadcrumbs'][] = ['label' => 'ผู้ใช้', 'url' => ['/admin/user']];
$this->params['breadcrumbs'][] = $this->title;
?>
 
<?php $form = ActiveForm::begin([
    'id'=>$profile->formName(),
    'layout' => 'horizontal',
    'enableAjaxValidation' => true,
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'wrapper' => 'col-sm-6',
        ],
    ],
]); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-user"></i> <?= Html::encode($this->title); ?></h4>
</div>
<div class="modal-body">
    <?= $form->field($profile, 'firstname') ?>
    <?= $form->field($profile, 'lastname') ?>
    <?= $form->field($profile, 'public_email')->label(Yii::t('chanpan','Public Email')) ?>
    <?= $form->field($profile, 'tel')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '9999999999',
    ]) ?>
    <?= $form->field($profile, 'bio')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '99/99/9999',
    ]) ?>
    <?php
        echo $form->field($profile, 'image')->widget(\trntv\filekit\widget\Upload::classname(), [
            'url' => ['/core/file-storage/avatar-upload'],
            'id'=>'image-profile'
        ])
    ?>
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="row">
                <div class="col-md-8">
                    <?= Html::submitButton(Yii::t('_user', 'Save'), ['class' => 'btn btn-primary btn-block']) ?> 
                </div>
                <div class="col-md-4 text-left" style="margin-top: 8px;">
                    <a href="#" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>


 

<?php ActiveForm::end(); ?>
 <?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('form#<?= $profile->formName()?>').on('beforeSubmit', function(e) {
    var $form = $(this);
    $.post(
        $form.attr('action'), //serialize Yii2 form
        $form.serialize()
    ).done(function(result) {
        if(result.status == 'success') {
            <?= SDNoty::show('result.message', 'result.status')?>
            if(result.action == 'create') {
                //$(\$form).trigger('reset');
                $(document).find('#modal-user').modal('hide');
                $.pjax.reload({container:'#user-grid-pjax'});
            } else if(result.action == 'update') {
                $(document).find('#modal-user').modal('hide');
                $.pjax.reload({container:'#user-grid-pjax'});
            }
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
 
