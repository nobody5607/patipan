<?php 
    $this->title = Yii::t('appmenu', 'Contact');
    $this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->user->can('edit_contact')): ?> 
    <a href="#" class="btn btn-primary btnEdit" data-url="<?= yii\helpers\Url::to(['/site/edit?params=contact'])?>"><i class="fa fa-pencil"></i></a>
<?php endif; ?>
<?= isset(\Yii::$app->params['contact'])?\Yii::$app->params['contact']:''?> 

    
<?php if (Yii::$app->user->can('edit_contact')): ?>     
<?=  \appxq\sdii\widgets\ModalForm::widget([
    'id' => 'modal-options',
    'options'=>['tabindex' => false], 
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('.btnEdit').on('click', function() {
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
<?php  \richardfan\widget\JSRegister::end(); ?>
<?php endif; ?>