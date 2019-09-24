<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Game */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Game',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Games'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
