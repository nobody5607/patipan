<?php

namespace backend\controllers;

use Yii;
use backend\models\Student;
use backend\models\search\Student as StudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use appxq\sdii\helpers\SDHtml;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
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
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {

        
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Student model.
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
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = new Student();
            $model->create_by = \common\modules\user\classes\CNUserFunc::getUserId();
            $model->create_date = date('Y-m-d H:i:s');
            $model->token = \Yii::$app->security->generateRandomString(20);
            $model->rstat = 1;
	    if ($model->load(Yii::$app->request->post())) {
                $post = \Yii::$app->request->post('Student');
                if($post['image'] != ''){
                    $model->image = \appxq\sdii\utils\SDUtility::array2String($post['image']);
                 }
		if ($model->save()) {
		    return \cpn\chanpan\classes\CNMessage::getSuccess('Create successfully');
		} else {
		    return \cpn\chanpan\classes\CNMessage::getError('Can not create the data.'.\yii\helpers\JSON::encode($model->errors), $model->errors);
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
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: DELETE, POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With,x-token');
        \Yii::$app->controller->enableCsrfValidation = false;
        
	$id = \Yii::$app->request->get('id','');
        $mobile = \Yii::$app->request->get('mobile','');
        $model = $this->findModel($id);
        $message = "";
        if ($model->load(Yii::$app->request->post())) {
            $post = \Yii::$app->request->post('Student');
            
            $model->update_by = \common\modules\user\classes\CNUserFunc::getUserId();
            $model->update_date = date('Y-m-d H:i:s');
            $model->rstat = 1;
            if($post['image'] != ''){
               $model->image = \appxq\sdii\utils\SDUtility::array2String($post['image']);
            }
            if ($model->save()) {
                if($mobile == '1'){
                    $message = "<div class='alert alert-success'><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a> แก้ไขข้อมูลนักเรียนสำเร็จ</div>"; 
                }else{
                    return \cpn\chanpan\classes\CNMessage::getSuccess('Update successfully');
                }
            } else {
                return \cpn\chanpan\classes\CNMessage::getError('Can not update the data.');
            }
        } 
            if($model->image != ''){
               $model->image = \appxq\sdii\utils\SDUtility::string2Array($model->image);
            }
            if($mobile == '1'){
                return $this->renderAjax('mobile', [
                    'model' => $model,
                    'message'=>$message
                ]);
            }
           
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
         
        
    }

    /**
     * Deletes an existing Student model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	if (Yii::$app->getRequest()->isAjax) {
	    $model = $this->findModel($id);
          
	    if ($model->delete()) {
                
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
	    Yii::$app->response->format = Response::FORMAT_JSON;
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
    
    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionTeacher()
    {
        $model = new \common\modules\user\models\Teacher();
        if ($model->load(\Yii::$app->request->post())) {
            $data = \Yii::$app->request->post();
            $user = new User();
            $profile = new Profile(); 
        }

        return $this->renderAjax('Teacher', [
            'model' => $model,
        ]);
    }
    
    
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
