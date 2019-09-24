<h3 class="text-center">เลือกประเภทเกมส์</h3> 
<?php if($types):?>
<div class="col-md-6 col-md-offset-3">
    <?php foreach($types as $k=>$v):?>
    <div style="margin-bottom: 15px;">
        <a href="<?= yii\helpers\Url::to(["/game/load-game?type={$v['id']}"])?>" class="btn btn-default btn-lg btn-block"><i class="fa fa-gamepad"></i> <?= $v['name']; ?></a>
        </div>
    <?php endforeach; ?>
</div>    
<?php endif; ?>
