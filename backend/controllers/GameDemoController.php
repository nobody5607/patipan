<?php
namespace backend\controllers;

use yii\web\Controller;
class GameDemoController extends Controller {
    public function actionIndex(){ 
        
        return $this->render('index');
    }
    public function actionShow(){ 
        
        return $this->render('show');
    }


}
