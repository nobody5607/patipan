<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Skin */

$this->title = Yii::t('app', 'Create Skin');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Skins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skin-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
