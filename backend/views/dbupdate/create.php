<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dbupdate */

$this->title = Yii::t('app', 'Create Dbupdate');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dbupdates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dbupdate-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
