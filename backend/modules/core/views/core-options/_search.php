<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\core\models\CoreOptionSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="core-options-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
	'layout' => 'horizontal',
	'fieldConfig' => [
	    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
	    'horizontalCssClasses' => [
		'label' => 'col-sm-2',
		'offset' => 'col-sm-offset-3',
		'wrapper' => 'col-sm-6',
		'error' => '',
		'hint' => '',
	    ],
	],
    ]); ?>

    <?= $form->field($model, 'option_id') ?>

    <?= $form->field($model, 'option_name') ?>

    <?= $form->field($model, 'option_value') ?>

    <?= $form->field($model, 'autoload') ?>

    <?= $form->field($model, 'input_label') ?>

    <?php // echo $form->field($model, 'input_hint') ?>

    <?php // echo $form->field($model, 'input_field') ?>

    <?php // echo $form->field($model, 'input_specific') ?>

    <?php // echo $form->field($model, 'input_data') ?>

    <?php // echo $form->field($model, 'input_required') ?>

    <?php // echo $form->field($model, 'input_validate') ?>

    <?php // echo $form->field($model, 'input_meta') ?>

    <?php // echo $form->field($model, 'input_order') ?>

    <div class="form-group">
	<div class="col-sm-offset-2 col-sm-6">
	    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
	    <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
	</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
