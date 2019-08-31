<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
 

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;

?>
<?php
$form = ActiveForm::begin([
            'id' => $model->formName(),
                //'enableAjaxValidation' => true,
                //'validationUrl'=> yii\helpers\Url::to(['/user/registration/validate-url'])
                //'enableClientValidation' => false,
        ]);
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php if (Yii::$app->session->hasFlash('error')): ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?= Yii::$app->session->getFlash('error') ?>
                    </div>
                <?php endif; ?>
                
               
                
                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'username') ?>

                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'confirm_password')->passwordInput() ?>
                <?php endif ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6" style="padding-left:0;">
                            <?= $form->field($model, 'firstname') ?>
                        </div>
                        <div class="col-md-6" style="padding-right:0;">
                            <?= $form->field($model, 'lastname') ?>
                        </div>
                    </div>
                </div>
		 
                 <?= $form->field($model, 'telephone')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => '9999999999',
                ]) ?>
                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block', 'id'=>'btnSubmit']) ?>

                
            </div>
        </div>
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
        </p>
    </div>
</div>
<?php ActiveForm::end(); ?>
 