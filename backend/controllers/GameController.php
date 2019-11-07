<?php

namespace backend\controllers;

use Yii;
use backend\models\Game;
use backend\models\search\Game as GameSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

/**
 * GameController implements the CRUD actions for Game model.
 */
class GameController extends Controller
{


    public function beforeAction($action) {
	if (parent::beforeAction($action)) {
        \Yii::$app->language = 'th';
	    if (in_array($action->id, array('create', 'update'))) {
		
	    }
	    return true;
	} else {
	    return false;
	}
    }
    
    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionIndex()
    {
       
        $searchModel = new GameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Game model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    return $this->renderAjax('view', [
		'model' => $this->findModel($id),
	    ]);
	} else {
	    return $this->render('view', [
		'model' => $this->findModel($id),
	    ]);
	}
    }

    /**
     * Creates a new Game model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = new Game();

	    if ($model->load(Yii::$app->request->post())) {
                $model->create_by = \common\modules\user\classes\CNUserFunc::getUserId();
		if ($model->save()) {
		    return \cpn\chanpan\classes\CNMessage::getSuccess('Create successfully');
		} else {
		    return \cpn\chanpan\classes\CNMessage::getError('Can not create the data.');
		}
	    } else {
                $model->number = rand(00,999);
		return $this->renderAjax('create', [
		    'model' => $model,
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    /**
     * Updates an existing Game model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = $this->findModel($id);

	    if ($model->load(Yii::$app->request->post())) {
		$model->create_by = \common\modules\user\classes\CNUserFunc::getUserId();
		if ($model->save()) {
		    return \cpn\chanpan\classes\CNMessage::getSuccess('Update successfully');
		} else {
		    return \cpn\chanpan\classes\CNMessage::getError('Can not update the data.');
		}
	    } else {
		return $this->renderAjax('update', [
		    'model' => $model,
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    /**
     * Deletes an existing Game model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	     
	    if ($this->findModel($id)->delete()) {
		return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully'); 
	    } else {
		return \cpn\chanpan\classes\CNMessage::getError('Can not delete the data.'); 
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    public function actionDeletes() {
	if (Yii::$app->getRequest()->isAjax) {
	     
	    if (isset($_POST['selection'])) {
		foreach ($_POST['selection'] as $id) {
		    $this->findModel($id)->delete();
		}
		return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully'); 
	    } else {
		return \cpn\chanpan\classes\CNMessage::getError('Can not delete the data.'); 
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }
    
    public function actionGameAll() {
        $user_id = Yii::$app->request->get('user_id','');
        $gameType = \backend\models\GameType::find()->all(); 
        return $this->renderAjax('game-all',[
            'types'=>$gameType,
            'user_id'=>$user_id
        ]);
    }
    public function actionLoadGame(){
        $type = Yii::$app->request->get('type');
        $user_id = Yii::$app->request->get('user_id','');
        $gameType = \backend\models\GameType::findOne($type);
        $games = Game::find()
                    ->where(['type' => $type])
                    ->orderBy(new \yii\db\Expression('rand()'))->limit(10)
                 ->all();
        $ids=[];
        foreach($games as $k=>$v){
            array_push($ids,$v['id']);
        }
        $ids = implode(',', $ids);
        $model = new \backend\models\Players();
        $model->id = time();
        $model->games = $ids;
        $model->scores = 0;
        $model->type = $type;
        $model->times= isset(\Yii::$app->params['times'])?\Yii::$app->params['times']:60;
        $model->index= 0;
        $model->user_id = $user_id;
        if(!$model->save()){
            \appxq\sdii\utils\VarDumper::dump($model->errors);
        }
        return $this->redirect(['/game/player?id='.$model->id.'&user_id='.$user_id]);
    }

    public function actionPlayer() {
         $id = Yii::$app->request->get('id');
         $user_id = Yii::$app->request->get('user_id','');
         $player = \backend\models\Players::findOne($id);
         $gameType = \backend\models\GameType::findOne($player['type']);
         $ids = explode(',', $player['games']);  
         //\appxq\sdii\utils\VarDumper::dump($id); 
         return $this->renderAjax('player',[
            'player'=>$player,
            'gameType'=>$gameType,
            'user_id'=>$user_id,
             'type'=>$player['type']
         ]);
    }
    public function actionLoadPlayer() {
        $id = Yii::$app->request->get('id');
        $game = Game::find()
                ->where(['id' => $id])->one();
        if($game){
            return $game['question'];
        }
    }
    public function actionGetScore() {
        $id = Yii::$app->request->get('id');
        $player = \backend\models\Players::findOne($id);
        //\appxq\sdii\utils\VarDumper::dump($player);
        if($player){
            return $player['scores'];
        }
    }
    public function actionListScore() {
        $type = Yii::$app->request->get('type');
        $user_id = Yii::$app->request->get('user_id');
        $player = \backend\models\Players::find()
            ->where(['type'=>$type,'user_id'=>$user_id])
            ->orderBy(['id'=>SORT_DESC])
            ->all();
        return $this->renderAjax('list-score',[
           'player' => $player,
            'user_id'=>$user_id
        ]);
    }
    public function actionCheckAnswer() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: DELETE, POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With,x-token');
        \Yii::$app->controller->enableCsrfValidation = false;

        $gameid     = \Yii::$app->request->get('gameid');
        $playerid   = \Yii::$app->request->get('playerid');
        $value = \Yii::$app->request->get('value');
        $num = \Yii::$app->request->get('num');
        
        $score = 0;
        $game = Game::find()->where(['id' => $gameid])->one();
        
        $player = \backend\models\Players::findOne($playerid);
        $answer = isset($game['answer']) ? $game['answer'] : '';
        $player->index = $num;
         
        if($value == $answer){
            $score += 1;
            $player->scores += $score; 
        } 
        $player->save();
        return Json::encode(['score'=>$score,'total'=>$player->scores]);
    }
    
    public function actionAbout() {
        return $this->renderAjax('about');
    }
    /**
     * Finds the Game model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Game the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Game::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
