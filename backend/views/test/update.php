<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Test */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Test',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
