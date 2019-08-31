<?php

namespace frontend\modules\products\controllers;

use Yii;
use common\models\StockProductDocs;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;
use yii\web\UploadedFile;


/**
 * StockProductDocsController implements the CRUD actions for StockProductDocs model.
 */
class StockProductDocsController extends Controller
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
     * Lists all StockProductDocs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => StockProductDocs::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StockProductDocs model.
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
     * Creates a new StockProductDocs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = new StockProductDocs();

	    if ($model->load(Yii::$app->request->post())) {
		$files = UploadedFile::getInstancesByName('StockProductDocs', 'icon');
                
                if ($files) {
                    foreach($files as $file){
                        $model = new StockProductDocs();
                        $model->id = \appxq\sdii\utils\SDUtility::getMillisecTime();
                        $realFileName = \appxq\sdii\utils\SDUtility::getMillisecTime();
                        $folder = "/web/source/products";
                        $path = Yii::getAlias('@storage') . "{$folder}";

                        $fileType = \appxq\sdii\utils\SDUtility::string2Array(isset(Yii::$app->params['brand_file_type']) ? Yii::$app->params['brand_file_type'] : []);
                        $type = $file->extension;
                        if (!in_array($file->extension, $fileType)) {
                            $type = 'jpg';
                        }
                        $filePath = "{$path}/{$realFileName}.{$type}";
                        if ($file->saveAs("{$filePath}")) {
                            $model->filename = "{$realFileName}.{$type}";
                            if (!$model->save()) {
                                return \cpn\chanpan\classes\CNMessage::getError('Can not create the data.');
                            }
                        }
                    }//end foreach
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Create successfully');
                }//end if
                if($model->save()){
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Create successfully');
                }else{
                    return \cpn\chanpan\classes\CNMessage::getError('Can not create the data.');
                }
	    } else {
		return $this->renderAjax('create', [
		    'model' => $model,
		]);
	    }
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    /**
     * Updates an existing StockProductDocs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = $this->findModel($id);

	    if ($model->load(Yii::$app->request->post())) {
		Yii::$app->response->format = Response::FORMAT_JSON;
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
     * Deletes an existing StockProductDocs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
            $model = $this->findModel($id);
	    if ($model) {
                //\appxq\sdii\utils\VarDumper::dump($model);
                $folder = "/web/source/products";
                $path = Yii::getAlias('@storage') . "{$folder}";
                @unlink("{$path}/{$model['filename']}");
                if($model->delete()){
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Delete successfully'); 
                }
	    } 
            return \cpn\chanpan\classes\CNMessage::getError('Can not delete the data.'); 
	} else {
	    throw new NotFoundHttpException('Invalid request. Please do not repeat this request again.');
	}
    }

    public function actionDeletes() {
	if (Yii::$app->getRequest()->isAjax) {
	    if (isset($_POST['selection'])) {
		foreach ($_POST['selection'] as $id) {
                   $model = $this->findModel($id);
                   if($model){
                       $folder = "/web/source/products";
                       $path = Yii::getAlias('@storage') . "{$folder}";
                       @unlink("{$path}/{$model['filename']}");
                       $model->delete();
                   }
		   
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
     * Finds the StockProductDocs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StockProductDocs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StockProductDocs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
