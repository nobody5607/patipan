<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Systemlog */

$this->title = Yii::t('app', 'Create Systemlog');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Systemlogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="systemlog-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
