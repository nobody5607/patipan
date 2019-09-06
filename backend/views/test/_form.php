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

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
    ]); ?>

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="itemModalLabel"><i class="fa fa-table"></i> จัดการแบบทดสอบก่อนเรียน/หรือหลังเรียน</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-4"><?php
                $items = [];
                for($i=1; $i<=20; $i++){
                    $items[$i] = $i;
                    //array_push($items, $i);
                }
                echo $form->field($model, 'number')->dropDownList($items,['prompt'=>'--เลือกลำดับหัวข้อ--']);
            ?></div>
            <div class="col-md-8">
                <?= $form->field($model, 'type')->dropDownList(['1'=>'แบบทดสอบก่อนเรียน','2'=>'แบบทดสอบหลังเรียน'],['prompt'=>'--เลือกประเภท--']) ?>
            </div>
            
        </div>
        
         <div class="row">
            <div class="col-md-12">
                    <?php 
                        $items = ['ก'=>'ก','ข'=>'ข','ค'=>'ค','ง'=>'ง'];
                       echo $form->field($model, 'answer')->inline()->radioList($items); 
                    ?>
            </div>
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
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-lg btn-block' : 'btn btn-primary btn-lg btn-block']) ?>
	
            </div>
        </div>
    </div> 

    <?php ActiveForm::end(); ?>

</div>

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
            if(result.action == 'create') {
                //$(\$form).trigger('reset');
                $(document).find('#modal-test').modal('hide');
                $.pjax.reload({container:'#test-grid-pjax'});
            } else if(result.action == 'update') {
                $(document).find('#modal-test').modal('hide');
                $.pjax.reload({container:'#test-grid-pjax'});
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