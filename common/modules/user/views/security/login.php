<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback','autofocus' => 'autofocus',  'tabindex' => '1'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback','tabindex' => '2'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>
<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>

                <?php if ($module->debug): ?>
                    <?= $form->field($model, 'login', [
                        'inputOptions' => [
                            'autofocus' => 'autofocus',
                            'class' => 'form-control',
                            'tabindex' => '1']])->dropDownList(LoginForm::loginList());
                    ?>

                <?php else: ?>

                    <?= $form->field($model, 'login',$fieldOptions1);
                    ?>

                <?php endif ?>

                <?php if ($module->debug): ?>
                    <div class="alert alert-warning">
                        <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                    </div>
                <?php else: ?>
                    <?= $form->field(
                        $model,
                        'password',
                        $fieldOptions2)
                        ->passwordInput()
                        ->label(
                            Yii::t('user', 'Password')
                            . ($module->enablePasswordRecovery ?
                                ' (' . Html::a(
                                    Yii::t('user', 'Forgot password?'),
                                    ['/user/recovery/request'],
                                    ['tabindex' => '5']
                                )
                                . ')' : '')
                        ) ?>
                <?php endif ?>
                 <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3']) ?>
                 <?= Html::submitButton(
                    Yii::t('user', 'Sign in'),
                    ['class' => 'btn btn-primary btn-block btn-lg', 'tabindex' => '4']
                ) ?>
               

               

                <?php ActiveForm::end(); ?>
                
                
                <!-- /.social-auth-links -->
                <?php if ($module->enableConfirmation): ?>
                    <p class="text-left">
                        <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
                    </p>
                <?php endif ?>
                <?php if ($module->enableRegistration): ?>
                    <p class="text-left">
                        <?= Html::a(Yii::t('user', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
                    </p>
                <?php endif ?>
                
            </div>
            
            
        </div>
        
    </div>
     
</div>
 