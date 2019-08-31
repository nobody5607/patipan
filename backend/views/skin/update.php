<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Skin */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Skin',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Skins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skin-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
