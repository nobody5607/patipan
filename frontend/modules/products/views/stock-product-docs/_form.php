<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\StockProductDocs */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="stock-product-docs-form">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="modal-header" style="background: #3c8dbc;color: #fff;">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="itemModalLabel"><i class="fa fa-table"></i> Stock Product Docs</h4>
    </div>
   
    <div class="modal-body">
	 <?php echo $form->field($model, 'filename[]')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*','multiple'=>true],
//                    'pluginOptions' => $pluginOptions
        ]);?>
    </div>
   <div class="modal-footer" style="background: #f3f3f3;">
        <div class="col-md-6 col-md-offset-3">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-lg btn-block' : 'btn btn-primary btn-lg btn-block']) ?>
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
    $('.btn').prop('disabled', true);     
    var $form = $(this);
    var formData = new FormData($(this)[0]);
    $.ajax({
        url:$form.attr('action'),
        type:'POST',
        data:formData,
        processData: false,
        contentType: false,
        cache: false,         
        enctype: 'multipart/form-data',
        success:function(result){
            $('.btn').prop('disabled', false);    
            if(result.status == 'success') {
                <?= SDNoty::show('result.message', 'result.status')?>
                if(result.action == 'create') {
                    //$(\$form).trigger('reset');
                    $(document).find('#modal-stock-product-docs').modal('hide');
                    $.pjax.reload({container:'#stock-product-docs-grid-pjax'});
                } else if(result.action == 'update') {
                    $(document).find('#modal-stock-product-docs').modal('hide');
                    $.pjax.reload({container:'#stock-product-docs-grid-pjax'});
                }
            } else {
                <?= SDNoty::show('result.message', 'result.status')?>
            } 
        }
    });    
     
    return false;
}); 
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>