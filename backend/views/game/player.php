<?php 
    $this->title = 'คุณกำลังเล่นเกมส์ '.$gameType['name'];
?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">คุณกำลังเล่นเกมส์ <?= $gameType['name']; ?>  </h2>
        <h3 class="text-center times-gay" id="blog-time">เวลา: <label id="times"><?= isset($player['times'])?$player['times']:''; ?></label> วินาที</h3>
        <h3 class="text-center total-score">คะแนน: <label id="score"><?= $player['scores']; ?></label></h3>
        <div id="preview-game"></div>
        <div>
            <input id="answer" data-id='<?= $player['id']; ?>' type="hidden">
            <input type="number" class="form-control input-lg" id="answer2" placeholder="ช่องตอบคำตอบ">
            <br>
            <button class="btn btn-lg btn-block btn-warning" id="btnSendAnswer">ตอบ</button>
        </div>
        <br>
        <a class="btn btn-success btn-lg btn-block" id="btnStartgame" href="<?= yii\helpers\Url::to(['/game/game-all'])?>">เริ่มเกมส์ใหม่</a>
    </div>
</div>

<?php \richardfan\widget\JSRegister::begin() ?>
<script>
    $("#btnStartgame").hide();
    var num = <?= $player['index'] ?>;
    var id = 0;
    var game = '<?= $player['games'] ?>';
    var games = game.split(",");
    var playerId = '<?= $player['id'] ?>';
    
    function initGame() {
        id = games[num];
        $('#answer').val(id);
        //console.log(num);
        if(num >= games.length){
            console.log(games.length);
            hideInput();
            return false;
        }
        showInput();
        loadPlayer(id);
        getScore(playerId);
    }
    function getScore(id){
        let url = '<?= yii\helpers\Url::to(['/game/get-score'])?>';
        $.get(url,{id:id}, function(res){
            $("#score").html(res);
        });
    }
    function loadPlayer(id){
        let url = '<?= yii\helpers\Url::to(['/game/load-player'])?>';
        $.get(url,{id:id}, function(res){
            $("#preview-game").html(res);
        });
    } 
    $('#btnSendAnswer').on('click', function(){
        showInput();
        console.log('games =>', games.length);
        console.log('num => ',num);
        let url = '<?= yii\helpers\Url::to(['/game/check-answer'])?>';
        let gameid = $("#answer").val();
        let value = $("#answer2").val();
        $.get(url,{playerid:playerId,gameid:gameid,value:value,num:num+1},function(res){
            $("#score").html(res);
            id = games[num];
            $('#answer').val(id);
            loadPlayer(id);
            clearInput();
        });
        if(num >= games.length-1){ 
            hideInput();
            $("#btnStartgame").show();
            return false;
        }
        num ++;
        
        
    });
    initGame();
    function clearInput(){
        $("#answer2").val('');
    }
    function showInput(){
        $("#answer2,#btnSendAnswer,#preview-game").fadeIn('slow');
    }
    function hideInput(){
        $("#answer2,#btnSendAnswer,#preview-game").fadeOut('slow');
    }
    
    var time = '<?= $player['times']?>';
    var myVar = setInterval(myTimer, 1000);
    function myTimer() {
      $("#times").html(time);
      time-=1;
      if(time <= -1){
          myStopFunction();
      }
    } 
    function myStopFunction() {
      clearInterval(myVar);
      hideInput();
      $("#blog-time").html('เวลาหมดแล้ว');
      $("#blog-time").addClass('times-red');
      $("#btnStartgame").show();
    }
    myTimer();
     
</script>
<?php
\richardfan\widget\JSRegister::end()?>

<?php \appxq\sdii\widgets\CSSRegister::begin()?>
<style>
    body{
        background:url(<?= \yii\helpers\Url::to('@web/img/bggame.png')?>) center;
        background-attachment: fixed;
        background-size: contain;
    }
    .input-lg {
        height: 60px !important;
        padding: 10px 16px;
        font-size: 20pt !important;
        line-height: 1.3333333;
        border-radius: 6px;
    }
    .btn-block {
        display: block;
        width: 100%;
        font-size: 25pt !important;
    }
    .btn-warning {
        color: #fff;
        background-color: #FF9800 !important;
        border-color: #FF9800;
        /* font-size: 20pt; */
    }
    .total-score{
        background: #8BC34A;
        padding: 10px;
        color: #fff;
        font-size: 35pt;
        font-weight: bold;
        border-radius: 3px;
    }
    .times-gay{
        background: #9E9E9E;
        padding: 10px;
        color: #fff;
        font-size: 35pt;
        font-weight: bold;
        border-radius: 3px;
    }
    .times-red{
        background: red;
        padding: 10px;
        color: #fff;
        font-size: 35pt;
        font-weight: bold;
        border-radius: 3px;
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>