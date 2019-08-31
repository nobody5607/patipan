<?php

namespace frontend\modules\products\controllers;

use Yii;
use common\models\StockProductGroup;
use frontend\modules\products\models\StockProductGroupSearch; 
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;
use yii\web\UploadedFile;

/**
 * StockProductGroupController implements the CRUD actions for StockProductGroup model.
 */
class StockProductGroupController extends Controller
{
    public function behaviors()
    {
        return [
/*	    'access' => [
		'class' => AccessControl::className(),
		'rules' => [
		    [
			'allow' => true,
			'actions' => ['index', 'view'], 
			'roles' => ['?', '@'],
		    ],
		    [
			'allow' => true,
			'actions' => ['view', 'create', 'update', 'delete', 'deletes'], 
			'roles' => ['@'],
		    ],
		],
	    ],*/
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
	if (parent::beforeAction($action)) {
	    if (in_array($action->id, array('create', 'update'))) {
		
	    }
	    return true;
	} else {
	    return false;
	}
    }
    
    /**
     * Lists all StockProductGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StockProductGroupSearch(); 
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [ 
            'searchModel' => $searchModel, 
            'dataProvider' => $dataProvider, 
        ]); 
    }
 

    /**
     * Creates a new StockProductGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function getChoice(){
        $brands = \common\models\StockBrand::find()->where(['deleted'=>'10'])->all();
        $categorys = \common\models\StockCategory::find()->where(['deleted'=>'10'])->all();
        $brands = \yii\helpers\ArrayHelper::map($brands, 'id', 'name');
        $categorys= \yii\helpers\ArrayHelper::map($categorys, 'id', 'name');
        $output = ['brands'=>$brands, 'categorys'=>$categorys];
        return $output;
    }
    public function actionCreate()
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = new StockProductGroup();
            
	    if ($model->load(Yii::$app->request->post())) {
                $files = UploadedFile::getInstancesByName('StockProductGroup', 'icon');
                $fileNameArr = [];
		if ($files) {
                    foreach($files as $file){
                        $realFileName = \appxq\sdii\utils\SDUtility::getMillisecTime();
                        $folder = "/web/source/products/group";
                        $path = Yii::getAlias('@storage') . "{$folder}";

                        $fileType = \appxq\sdii\utils\SDUtility::string2Array(isset(Yii::$app->params['brand_file_type']) ? Yii::$app->params['brand_file_type'] : []);
                        $type = $file->extension;
                        if (!in_array($file->extension, $fileType)) {
                            $type = 'jpg';
                        }
                        $filePath = "{$path}/{$realFileName}.{$type}";
                        if ($file->saveAs("{$filePath}")) {
                            array_push($fileNameArr, "{$realFileName}.{$type}");
                        } 
                    }//end foreach
                }//end if
                $model->id = \appxq\sdii\utils\SDUtility::getMillisecTime();
                if($fileNameArr){
                    $model->icon = implode(",",$fileNameArr);
                } 
                $model->deleted = 10;
                if($model->save()){
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Create successfully');
                }else{
                    return \cpn\chanpan\classes\CNMessage::getError('Can not create the data.');
                }
	    } else {
                $itemsChoices = $this->getChoice();
		return $this->renderAjax('create', [
		    'model' => $model,
                    'itemsChoices'=>$itemsChoices,
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    /**
     * Updates an existing StockProductGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = $this->findModel($id);
            if($model->icon){
                \Yii::$app->session['icon'] = $model->icon;
            }
            
	    if ($model->load(Yii::$app->request->post())) {
		$files = UploadedFile::getInstancesByName('StockProductGroup', 'icon');
//                \appxq\sdii\utils\VarDumper::dump($files);
                $fileNameArr = [];
		if ($files) {
                    foreach($files as $file){
                        $realFileName = \appxq\sdii\utils\SDUtility::getMillisecTime();
                        $folder = "/web/source/products/group";
                        $path = Yii::getAlias('@storage') . "{$folder}";

                        $fileType = \appxq\sdii\utils\SDUtility::string2Array(isset(Yii::$app->params['brand_file_type']) ? Yii::$app->params['brand_file_type'] : []);
                        $type = $file->extension;
                        if (!in_array($file->extension, $fileType)) {
                            $type = 'jpg';
                        }
                        $filePath = "{$path}/{$realFileName}.{$type}";
                        if ($file->saveAs("{$filePath}")) {
                            array_push($fileNameArr, "{$realFileName}.{$type}");
                        } 
                    }//end foreach
                }//end if
                if(!empty($fileNameArr)){ 
                    $iconStr = implode(",",$fileNameArr);
                    $iconOld = \Yii::$app->session['icon'];
                    $model->icon= "{$iconOld},{$iconStr}";
                }else{
                    $model->icon = \Yii::$app->session['icon'];
                } 
                //\appxq\sdii\utils\VarDumper::dump('ok');
                if($model->save()){
                    \Yii::$app->session['icon']='';
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Update successfully');
                }else{
                    return \cpn\chanpan\classes\CNMessage::getError('Can not update the data.', $model->errors);
                }
	    } else {
                $itemsChoices = $this->getChoice();
		return $this->renderAjax('update', [
		    'model' => $model,
                    'itemsChoices'=>$itemsChoices,
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    /**
     * Deletes an existing StockProductGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = $this->findModel($id);
            if($model){
                 $model->deleted = 30;
                 if($model->save()){
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully'); 
                }else{
                    return \cpn\chanpan\classes\CNMessage::getError('Can not delete the data.'); 
                }
            }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }
    public function actionDeleteFile(){
        $data = \Yii::$app->request->post('key', '');
        $data = base64_decode($data);
        $data = \appxq\sdii\utils\SDUtility::string2Array($data);
        $id = $data['id'];
        
        $model = StockProductGroup::find()->where(['id'=>$id])->one();
        $icon = explode(',', $model->icon);
        foreach($icon as $k=>$v){
            if($v == $data['fileName']){
                unset($icon[$k]);
            }
        }
        $folder = "/web/source/products/group";
        $path = Yii::getAlias('@storage') . "{$folder}";
        $filePath = "{$path}/{$data['fileName']}";
        @unlink($filePath);
        $model->icon = implode(',', $icon);
        if($model->save()){
            return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully'); 
        }else{
            return \cpn\chanpan\classes\CNMessage::getError('Can not delete the data.'); 
        }
        
    }
    public function actionDeletes() {
	if (Yii::$app->getRequest()->isAjax) {
	    if (isset($_POST['selection'])) {
		foreach ($_POST['selection'] as $id) {
		    $model = $this->findModel($id);
                    $model->deleted = 30;
                    $model->save();
		}
		return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully'); 
	    } else {
		return \cpn\chanpan\classes\CNMessage::getError('Can not delete the data.'); 
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }
    
    /**
     * Finds the StockProductGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StockProductGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StockProductGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
