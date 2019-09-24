<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Game */

$this->title = Yii::t('app', 'Create Game');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Games'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
