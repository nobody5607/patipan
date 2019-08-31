<?php

namespace frontend\modules\products\controllers;

use Yii;
use common\models\StockProductItems;
use frontend\modules\products\models\StockProductItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

/**
 * StockProductItemsController implements the CRUD actions for StockProductItems model.
 */
class StockProductItemsController extends Controller
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
     * Lists all StockProductItems models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StockProductItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function getProductGroup(){
        $productGroups = \frontend\modules\products\classes\CNProducts::getProductGroup();
        $productGroups = \yii\helpers\ArrayHelper::map($productGroups, 'id', 'name');
        return $productGroups;
         
    }  
    public function actionCreate()
    {
        
        if (Yii::$app->getRequest()->isAjax) {
	    $model = new StockProductItems();

	    if ($model->load(Yii::$app->request->post())) {
//                if($model->validate())
                $files = \yii\web\UploadedFile::getInstancesByName('StockProductItems', 'icon');
                $fileNameArr = [];
		if ($files) {
                    foreach($files as $file){
                        $realFileName = \appxq\sdii\utils\SDUtility::getMillisecTime();
                        $folder = "/web/source/products/items";
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
                $productGroup = $this->getProductGroup();
                //\appxq\sdii\utils\VarDumper::dump('ok');
		return $this->renderAjax('create', [
		    'model' => $model,
                    'productGroup'=>$productGroup
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    /**
     * Updates an existing StockProductItems model.
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
		$files = \yii\web\UploadedFile::getInstancesByName('StockProductGroup', 'icon');
                //\appxq\sdii\utils\VarDumper::dump($files);
                $fileNameArr = [];
		if ($files) {
                    foreach($files as $file){
                        $realFileName = \appxq\sdii\utils\SDUtility::getMillisecTime();
                        $folder = "/web/source/products/items";
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
                if($model->save()){
                    \Yii::$app->session['icon']='';
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Update successfully');
                }else{
                    return \cpn\chanpan\classes\CNMessage::getError('Can not update the data.', $model->errors);
                }
	    } else {
                $productGroup = $this->getProductGroup();
		return $this->renderAjax('update', [
		    'model' => $model,
                    'productGroup'=>$productGroup
		]);
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
        
        $model = $this->findModel($id);
        //\appxq\sdii\utils\VarDumper::dump($model);
        $icon = explode(',', $model->icon);
        foreach($icon as $k=>$v){
            if($v == $data['fileName']){
                unset($icon[$k]);
            }
        }
        $folder = "/web/source/products/items";
        $path = Yii::getAlias('@storage') . "{$folder}";
        $filePath = "{$path}/{$data['fileName']}";
        
        $model->icon = implode(',', $icon);
        if($model->save()){
            @unlink($filePath);
            return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully'); 
        }else{
            return \cpn\chanpan\classes\CNMessage::getError('Can not delete the data.', $model->errors); 
        }
        
    }

    /**
     * Deletes an existing StockProductItems model.
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
     * Finds the StockProductItems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StockProductItems the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StockProductItems::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
