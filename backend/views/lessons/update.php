<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Lessons */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Lessons',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lessons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lessons-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
