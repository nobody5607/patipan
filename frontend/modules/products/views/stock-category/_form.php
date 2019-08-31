<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\StockCategory */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="stock-category-form">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
    ]); ?>

    <div class="modal-header" style="background: #3c8dbc;color: #fff;">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="itemModalLabel"><i class="fa fa-table"></i> Stock Category</h4>
    </div>

    <div class="modal-body">
	 <?php 
            $items = \appxq\sdii\utils\SDUtility::string2Array(isset(\Yii::$app->params['category_types']) ? \Yii::$app->params['category_types'] : '');
           // \appxq\sdii\utils\VarDumper::dump($items)
        ?>
	<?= $form->field($model, 'type')->dropDownList($items,['prompt'=> Yii::t('product','Select Category type')]) ?>
        <?= $form->field($model, 'category_id')->dropDownList($mainCateGory,['prompt'=> Yii::t('product','Select Category')]) ?>
	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?php  echo $form->field($model, 'description')->widget(\cpn\chanpan\widgets\CNFroalaEditorWidget::className(), [
                'toolbar_size'=>'lg',
                'options'=>['class'=>'eztemplate'],
            ]);//->hint('Default Template <a class="btn btn-warning btn-xs btn-template" data-widget="{tab-widget}">Use Default</a>'); 
        ?>

	<?php 
                $storageUrl = isset(Yii::$app->params['storageUrl']) ? Yii::$app->params['storageUrl'] : '';
                $path = '/source/brand/'; 
                $pluginOptions = [];
                if($model->icon != ''){
                    $pluginOptions = [
                        'initialPreview'=>[
                                "{$storageUrl}/{$path}/{$model['icon']}"
                        ],
                        'initialPreviewAsData'=>true,
                    ];
                }
                
                            
                echo $form->field($model, 'icon')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => $pluginOptions
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
                $(document).find('#modal-stock-category').modal('hide');
                $.pjax.reload({container:'#stock-category-grid-pjax'});
            } else if(result.action == 'update') {
                $(document).find('#modal-stock-category').modal('hide');
                $.pjax.reload({container:'#stock-category-grid-pjax'});
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