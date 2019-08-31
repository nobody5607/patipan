<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

?>

<div class="row">
    <div class="col-md-6 col-md-offset-6">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => ['data-pjax' => true ],
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
        ]); ?>
        <div class="input-group">
          <?= Html::activeTextInput($model, 'q',['class'=>'form-control','placeholder'=> Yii::t('chanpan','Username, Name and Sitecode')]) ?>
          <span class="input-group-btn">
              <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i> <?= Yii::t('chanpan','Search')?></button>
            <?php //Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-default']) ?>
          </span>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>