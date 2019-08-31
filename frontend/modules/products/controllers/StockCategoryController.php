<?php

namespace frontend\modules\products\controllers;

use Yii;
use common\models\StockCategory;
use frontend\modules\products\models\StockCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response; 
use appxq\sdii\helpers\SDHtml;
use yii\web\UploadedFile;

/**
 * StockCategoryController implements the CRUD actions for StockCategory model.
 */
class StockCategoryController extends Controller
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
     * Lists all StockCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StockCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new StockCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = new StockCategory();

	     if ($model->load(Yii::$app->request->post())) {
		$model->deleted = 10;
                $files = UploadedFile::getInstancesByName('StockCategory', 'icon');
                if ($files) {
                    $file = $files[0];
                    $realFileName = \appxq\sdii\utils\SDUtility::getMillisecTime();
                    $folder = "/web/source/brand";
                    $path = Yii::getAlias('@storage') . "{$folder}";

                    $fileType = \appxq\sdii\utils\SDUtility::string2Array(isset(Yii::$app->params['brand_file_type']) ? Yii::$app->params['brand_file_type'] : []);
                    $type = $file->extension;
                    if (!in_array($file->extension, $fileType)) {
                        $type = 'jpg';
                    }
                    $filePath = "{$path}/{$realFileName}.{$type}";
                    if ($file->saveAs("{$filePath}")) {
                        $model->icon = "{$realFileName}.{$type}";
                        if ($model->save()) {
                            return \cpn\chanpan\classes\CNMessage::getSuccess('Create successfully');
                        } else {
                            return \cpn\chanpan\classes\CNMessage::getError('Can not create the data.');
                        }
                    }
                }
                return \cpn\chanpan\classes\CNMessage::getError('Can not create the data.');
            } else {
                $mainCateGory = $this->getCateGory();
                //\appxq\sdii\utils\VarDumper::dump($mainBrands);
		return $this->renderAjax('create', [
		    'model' => $model,
                    'mainCateGory'=>$mainCateGory
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }
    public function getCateGory(){
        $brand = StockCategory::find()->where(['type'=>1])->all();
        $mainCateGory = \yii\helpers\ArrayHelper::map($brand, 'id', 'name');
        return $mainCateGory;
    }
    /**
     * Updates an existing StockCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = $this->findModel($id);
            Yii::$app->session['icon'] = isset($model->icon) ? $model->icon : '';
	    if ($model->load(Yii::$app->request->post())) {
                
		$files = UploadedFile::getInstancesByName('StockCategory', 'icon');
                if ($files) {
                    $file = $files[0];
                    $realFileName = \appxq\sdii\utils\SDUtility::getMillisecTime();
                    $folder = "/web/source/brand";
                    $path = Yii::getAlias('@storage') . "{$folder}";
                    @unlink("{$path}/{$model->icon}");
                    $fileType = \appxq\sdii\utils\SDUtility::string2Array(isset(Yii::$app->params['brand_file_type']) ? Yii::$app->params['brand_file_type'] : []);
                    $type = $file->extension;
                    if (!in_array($file->extension, $fileType)) {
                        $type = 'jpg';
                    }
                    $filePath = "{$path}/{$realFileName}.{$type}";
                    if ($file->saveAs("{$filePath}")) {
                        $model->icon = "{$realFileName}.{$type}";
                        if ($model->save()) {
                            return \cpn\chanpan\classes\CNMessage::getSuccess('Create successfully');
                        } else {
                            return \cpn\chanpan\classes\CNMessage::getError('Can not create the data.');
                        }
                    }
                }
                //s\appxq\sdii\utils\VarDumper::dump($model->icon);
                $model->icon = Yii::$app->session['icon'];
                //\appxq\sdii\utils\VarDumper::dump(Yii::$app->session['icon']);
                if($model->save()){
                    Yii::$app->session['icon']='';
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Create successfully');
                }else{
                    return \cpn\chanpan\classes\CNMessage::getError('Can not create the data.');
                }
	    } else {
                $mainCateGory = $this->getCateGory();
		return $this->renderAjax('update', [
		    'model' => $model,
                    'mainCateGory'=>$mainCateGory
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    /**
     * Deletes an existing StockCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
   public function actionDelete($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = $this->findModel($id);
            $model->deleted = 30;
	    if ($model->save()) {
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
            //\appxq\sdii\utils\VarDumper::dump($_POST);
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
     * Finds the StockCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StockCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StockCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
