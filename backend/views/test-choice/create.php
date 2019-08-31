<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TestChoice */

$this->title = Yii::t('app', 'Create Test Choice');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Test Choices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-choice-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
