<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Student */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Student',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
