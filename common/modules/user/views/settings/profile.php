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
use dektrium\user\helpers\Timezone;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $model
 */

$this->title = Yii::t('_user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b> <?= Html::encode($this->title) ?></b>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'profile-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                ]); ?>

                <?= $form->field($model, 'firstname') ?>
                <?= $form->field($model, 'lastname') ?>

                <?= $form->field($model, 'public_email') ?>
                <?=
                $form->field($model, 'tel')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => '9999999999',
                ])
                ?>

                <?= $form->field($model, 'website') ?>

                <?= $form->field($model, 'location') ?>

                <?= $form
                    ->field($model, 'timezone')
                    ->dropDownList(
                        ArrayHelper::map(
                            Timezone::getAll(),
                            'timezone',
                            'name'
                        )
                    ); ?>                 
                <?=
                    $form->field($model, 'bio')->widget(\yii\widgets\MaskedInput::className(), [
                        'mask' => '99/99/9999',
                    ])
                ?>
                <?php
                    echo $form->field($model, 'image')->widget(\trntv\filekit\widget\Upload::classname(), [
                        'url' => ['/core/file-storage/avatar-upload']
                    ])
                ?>
                
                <div class="form-group field-profile-bio">
                    <label class="col-lg-3 control-label" for="profile-bio"><?= Yii::t('appmenu', 'Role') ?></label>
                    <div class="col-lg-9">
                        <?php
                            $user_id = isset(Yii::$app->user->id) ? Yii::$app->user->id : '';
                            $roles = \cpn\chanpan\classes\CNRoles::getAuthAssign($user_id);
                            foreach ($roles as $k => $v) {
                                echo "<div style='margin-top:10px;'>{$v}</div> ";
                            }
                        ?>  
                    </div>
                     
                    </div>  
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton(Yii::t('_user', 'Save'), ['class' => 'btn btn-block btn-success btn-lg']) ?>
                        <br>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    
</div>
