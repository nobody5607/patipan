<?php
 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;
 

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row"> 
    <div class="col-md-6 col-md-offset-3">
        <div class="box box-primary">
    <div class="box-header">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-title">
                    <i class="fa fa-user"></i> <?= Html::encode($this->title); ?>
                </div>
            </div>
        </div>
    </div> 
    <div class="box-body"> 
        <?php
            $form = ActiveForm::begin([
                'id'=>$model->formName(),
            ]);
        ?> 
            <?= $form->field($model, 'username')->textInput(['autofocus' => 'autofocus', 'autocomplete' => 'off']) ?>
            <?= $form->field($model, 'email')->textInput(['autocomplete' => 'off']) ?>
            <?= $form->field($model, 'password')->passwordInput([])->hint(Yii::t('app', 'รหัสผ่านต้องมีอักขระอย่างน้อย 6 ตัว')) ?>
            <?= $form->field($model, 'confirm_password')->passwordInput() ?>
            <?= $form->field($model, 'firstname')->textInput(['autocomplete' => 'off']) ?>
            <?= $form->field($model, 'lastname')->textInput(['autocomplete' => 'off']) ?>
            <?= $form->field($model, 'tel')->textInput() ?>
        <div class="form-group text-center">
            <?= Html::submitButton(Yii::t('app', 'Submmit'), ['class' => 'btn btn-primary btn-lg']) ?>&nbsp;&nbsp;
            <?= Html::a(Yii::t('app', 'ยกเลิก'),['/admin/user'], ['class' => '']) ?>
        </div>
        <?php
            ActiveForm::end();
        ?> 
    </div></div>
</div>
    <?php \richardfan\widget\JSRegister::begin(); ?>
    <script>
    $('form#<?= $model->formName() ?>').on('beforeSubmit', function(e) {  
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
          <?= SDNoty::show('result.message', 'result.status') ?>
          if(result['status'] == 'success'){
              setTimeout(function(){
                //location.href = '<?= \yii\helpers\Url::to(['/admin/user'])?>';
              },1000);  
          }        
                 
        }
      }).fail(function( jqXHR, textStatus ) {
          <?= SDNoty::show('result.message', 'result.status') ?>
      });    
     
    return false;
}); 
    </script>
    <?php \richardfan\widget\JSRegister::end(); ?>