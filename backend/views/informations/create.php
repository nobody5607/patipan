<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Informations */

$this->title = Yii::t('app', 'Create Informations');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Informations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informations-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
