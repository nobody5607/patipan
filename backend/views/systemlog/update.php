<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Systemlog */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Systemlog',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systemlogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="systemlog-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
