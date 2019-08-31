<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $model common\models\StockProductItems */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="stock-product-items-form">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="modal-header" style="background: #3c8dbc;color: #fff;">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="itemModalLabel"><i class="fa fa-table"></i> Stock Product Items</h4>
    </div>

    <div class="modal-body">
	<?= $form->field($model, 'group_id')->dropDownList($productGroup,['prompt'=> Yii::t('product', 'Select Product group')]) ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'size')->textarea(['rows' => 6]) ?>
	<?= $form->field($model, 'weight')->textarea(['rows' => 6]) ?>
	<?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'price_update')->textInput() ?>
        
        <?php 
            $pluginOptions = [];
            if(isset($model['icon'])){
                $storageUrl = isset(Yii::$app->params['storageUrl']) ? Yii::$app->params['storageUrl'] : '';
                $path = '/source/products/items/';
                $icons = [];
                $model['icon'] = explode(',', $model['icon']);
                $initialPreviewConfig = [];
                foreach ($model['icon'] as $key => $v) {
                    array_push($icons, "{$storageUrl}{$path}{$v}");  
                    $keyStart = appxq\sdii\utils\SDUtility::array2String(['fileName'=>$v, 'id'=>$model->id]);
                    
                    $initialPreviewConfig[$key] = [
                        'url'=>\yii\helpers\Url::to(['/products/stock-product-items/delete-file']),
                        'key'=> base64_encode($keyStart)
                    ];
                }
                if ($model->icon) {
                    $pluginOptions = [
                        'initialPreview' => $icons,
                        'initialPreviewAsData' => true,
                        'overwriteInitial'=>false,
                        'fileActionSettings' => [
                            'removeIcon' => '<span><i class="fa fa-trash"></i> delete</span> ',
                        ],
                        'initialPreviewConfig'=>$initialPreviewConfig
                    ];
                }
            }
        ?>
        <?= $form->field($model, 'icon[]')->widget(kartik\file\FileInput::classname(), [
                    'options' => ['accept' => 'image/*','multiple'=>true],
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
// JS script

$('.kv-file-remove').addClass('btn-danger');
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
                    $(document).find('#modal-stock-product-items').modal('hide');
                    $.pjax.reload({container:'#stock-product-items-grid-pjax'});
                } else if(result.action == 'update') {
                    $(document).find('#modal-stock-product-items').modal('hide');
                    $.pjax.reload({container:'#stock-product-items-grid-pjax'});
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