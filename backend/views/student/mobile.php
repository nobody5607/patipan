<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<div class="student-form">
    <?php if($message != ''):?>
        
        <?= $message;?>
    <?php endif; ?>
    
    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>
        <div class="row">
            <div class='col-xs-6'><?= $form->field($model, 'id')->textInput() ?></div>
            <div class='col-xs-6'><?= $form->field($model, 'password')->passwordInput() ?></div>
            
        </div>
        <div class="row">
            <div class='col-xs-8'><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
            <div class='col-xs-4'><?= $form->field($model, 'number')->textInput() ?></div>
        </div>
        <div class="row">
            <div class='col-xs-6'><?= $form->field($model, 'room')->textInput(['maxlength' => true]) ?></div>
            <div class='col-xs-6'> <?php $item = ['1' => 'ชาย', '2' => 'หญิง']; ?>
                <?= $form->field($model, 'sex')->dropDownList($item, ['prompt' => '--เลือกเพศ--']) ?></div>
        </div>
        <div class=""> 
            <div class="">
                <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>
                <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?> 
            <?php
                echo $form->field($model, 'image')->widget(\trntv\filekit\widget\Upload::classname(), [
                    'url' => ['/core/file-storage/avatar-upload']
                ]);
            ?>
          <?= Html::submitButton('แก้ไขข้อมูล',[
                        'class'=>'btn btn-primary btn-lg btn-block'
                    ]) ?>
            </div>
        </div>
        

<?php ActiveForm::end(); ?>

</div>

