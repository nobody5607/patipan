<?php
    $this->title = "เกมส์ทั้งหมด";
?>
<h3 class="text-center">เลือกประเภทเกมส์</h3>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<?php if ($types): ?>
    <div class="col-md-6 col-md-offset-3 text-center" style="margin-bottom: 10px;">
        <button onclick="playAudio()" type="button" class="btn btn-success btnPlayMusic"><i
                    class="glyphicon glyphicon-play"></i> เปิดเสียง
        </button>
        <button onclick="pauseAudio()" type="button" class="btn btn-danger btnStopMusic"><i
                    class="glyphicon glyphicon-pause"></i> ปิดเสียง
        </button>
        <audio id="myAudio">
            <source src="<?= \yii\helpers\Url::to('@web/mp3/bg.mp3') ?>" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>
    <div class="col-md-6 col-md-offset-3">

        <?php foreach ($types as $k => $v): ?>
            <div style="margin-bottom: 15px;">
                <a style="font-size:20pt;font-weight: bold;" href="<?= yii\helpers\Url::to(["/game/load-game?type={$v['id']}&user_id={$user_id}"]) ?>"
                   class="">
                    <?php
                        $image = \yii\helpers\Url::to('@web/img/').$v['image']
                    ?>
                    <img src="<?= $image; ?>" class="img img-responsive">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php \richardfan\widget\JSRegister::begin(); ?>
<script>
    var x = document.getElementById("myAudio");

    function playAudio() {
        x.play();
    }

    function pauseAudio() {
        x.pause();
    }

    setTimeout(function () {
        $(".btnPlayMusic").trigger('click');
    }, 1000);
</script>
<?php \richardfan\widget\JSRegister::end(); ?>

<?php \appxq\sdii\widgets\CSSRegister::begin();?>
<style>
    body{
        background: white url("<?= \yii\helpers\Url::to('@web/img/gameall.jpg')?>") center;
        background-size: contain;
        background-attachment: fixed;
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>
