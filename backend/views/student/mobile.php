<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div class="student-form">
    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>
        <div class="">
            <div class=''><?= $form->field($model, 'id')->textInput() ?></div>
            <div class=''><?= $form->field($model, 'password')->passwordInput() ?></div>
            <div class=''><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
        </div>
        <div class="">
            <div class=''><?= $form->field($model, 'number')->textInput() ?></div>
            <div class=''><?= $form->field($model, 'room')->textInput(['maxlength' => true]) ?></div>
            <div class=''>
                <?php $item = ['1' => 'ชาย', '2' => 'หญิง']; ?>
                <?= $form->field($model, 'sex')->dropDownList($item, ['prompt' => '--เลือกเพศ--']) ?>
            </div>
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
        $.post($form.attr('action'),$form.serialize()).done(function (result) {
            if (result.status == 'success') { 
            } else {
               console.log(result.status);
            }
        }).fail(function () { 
            console.error('server error');
        });
        return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end(); ?>