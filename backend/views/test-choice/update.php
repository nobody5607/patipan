<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TestChoice */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Test Choice',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Test Choices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-choice-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
