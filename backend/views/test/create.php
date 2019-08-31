<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Test */

$this->title = Yii::t('app', 'Create Test');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
