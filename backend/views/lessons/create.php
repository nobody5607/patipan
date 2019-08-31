<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Lessons */

$this->title = Yii::t('app', 'Create Lessons');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lessons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lessons-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
