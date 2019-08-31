<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Options */

$this->title = Yii::t('app', 'Create Options');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="options-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
