<?php
use yii\helpers\Html;
use backend\components\AppComponent;
use cpn\chanpan\widgets\CNMenu;
?>
<?php
    $moduleID = '';
    $controllerID = '';
    $actionID = '';

    if (isset(Yii::$app->controller->module->id)) {
        $moduleID = Yii::$app->controller->module->id;
    }
    if (isset(Yii::$app->controller->id)) {
        $controllerID = Yii::$app->controller->id;
    }
    if (isset(Yii::$app->controller->action->id)) {
        $actionID = Yii::$app->controller->action->id;
    }
 
    ?>
<header class="main-header">
    <?php 
        $initialNameApp = isset(\Yii::$app->params['initial_name_app'])?\Yii::$app->params['initial_name_app']:'App';
        $nameApp = isset(\Yii::$app->params['name_app'])?\Yii::$app->params['name_app']:'App';
        $logoImg =isset(\Yii::$app->params['logoImg']) && Yii::$app->params['logoImg'] != '' ? Yii::$app->params['logoImg']:\yii\helpers\Url::to('@web/img/home.png');
    ?>
    <?= Html::a('<span class="logo-mini"><img src="'.$logoImg.'"></span><span class="logo-lg"><img src="'.$logoImg.'"> ' . $initialNameApp . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-fixed-top" role="navigation"> 
    <div class="navbar-header">
      <?= AppComponent::slideToggleRight()?>  
      <?= AppComponent::slideToggleLeft()?>
        <a class="navbar-brand" href="#"><?= $nameApp; ?></a>  
    </div>
<div class="container-fluid">
    <div class="collapse navbar-collapse" id="cnNavbar">       
      
        <?php 
        echo yii\bootstrap\Nav::widget([
                'options'=>['class'=>'nav navbar-nav  navbar-right'],
                'items'=> AppComponent::menuRight(),
                'encodeLabels'=>FALSE
            ]);
     ?>  
     <?php 
        // echo '<div id="btnLanguage" class="navbar-text pull-right" >';
        // echo \lajax\languagepicker\widgets\LanguagePicker::widget([
        //     'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_DROPDOWN,
        //     'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_SMALL
        // ]);
            
        // echo '</div>';
        
     ?>   
      
   
        
    </div>
  </div>
    </nav>
</header>
<?php 
$this->registerCss("
 #leftMenu{position:fixed;}
 header.main-header .logo {
    position: fixed;
}
 @media screen and (max-width: 860px) {
    #iconslideToggle {
      float:right;
    }
    .skin-blue .main-header .logo{
        display:none;
    }
    #btnLanguage{
            text-align: center;
            width: 100%;
    }
  }
");
?>
