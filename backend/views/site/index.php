<?php 
    $this->title = Yii::t('appmenu', 'Home');
?>
<?php if (Yii::$app->user->can('edit_home')): ?>
    <a href="#" class="btn btn-primary btnEdit" data-url="<?= yii\helpers\Url::to(['/site/edit?params=home']) ?>"><i class="fa fa-pencil"></i></a>
<?php endif; ?>
<div class="text-muted">
    <?= isset(\Yii::$app->params['home']) ? \Yii::$app->params['home'] : '' ?> 
</div>
    
<?php if (Yii::$app->user->can('edit_home')): ?>    
    
<?=
\appxq\sdii\widgets\ModalForm::widget([
    'id' => 'modal-options',
    'options' => ['tabindex' => false],
    'size'=>'modal-lg'
]);
?>

<?php
\richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]);
?>
<script>
// JS script
    $('.btnEdit').on('click', function () {
        let url = $(this).attr('data-url');
        modalOption(url);
        //alert(url);
        return false;
    });
    function modalOption(url) {
        $('#modal-options .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
        $('#modal-options').modal('show')
                .find('.modal-content')
                .load(url);
    }
</script>
<?php \richardfan\widget\JSRegister::end(); ?>
<?php endif; ?>