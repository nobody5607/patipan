<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Dbupdate */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Dbupdate',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dbupdates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dbupdate-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
