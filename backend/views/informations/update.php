<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Informations */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Informations',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Informations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informations-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
