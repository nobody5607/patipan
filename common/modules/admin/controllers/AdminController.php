<?php

namespace common\modules\admin\controllers;

use dektrium\user\controllers\AdminController as BaseAdminController;
use dms\aomruk\classese\Notify;
use yii\helpers\Url;
use common\modules\user\models\UserSearch;
use yii\helpers\ArrayHelper;
use Yii;
use common\modules\user\classes\AdminClasses;
use common\modules\user\models\Profile;
use common\modules\user\models\User;
use yii\data\ActiveDataProvider;
use common\modules\user\models\RegistrationForm;
use yii\web\NotFoundHttpException;

class AdminController extends BaseAdminController {
    public function actionIndex()
    {
            
        Url::remember('', 'actions-redirect');
        $searchModel  = \Yii::createObject(UserSearch::className());
        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }
    public function actionCreate(){
        /** @var User $user */
        $model = new RegistrationForm(); 
        if ($model->load(\Yii::$app->request->post())) {
            $post = \Yii::$app->request->post('register-form'); 
            $password = isset($post['password'])?$post['password']:'';
            $username = isset($post['username'])?$post['username']:'';
            $email = isset($post['email'])?$post['email']:'';
            $passwordHash = \Yii::$app->security->generatePasswordHash($password);
            $user = new User();
            $user->id = time();
            $user->email = $email;
            $user->username = $username;
            $user->password_hash = $passwordHash;
            $user->confirmed_at = time();
            $user->username = isset($post['username'])?$post['username']:'';
            $user->created_at = time();
            $user->updated_at = time();
            $user->create_date = date('Y-m-d H:i:s');
            $user->update_date = date('Y-m-d H:i:s');
            
            if(\common\modules\user\classes\CNUserFunc::checkUser('username', $username)){                
                return \cpn\chanpan\classes\CNMessage::getError("Username {$username} ถูกใช้งานแล้ว");
            }            
            if(\common\modules\user\classes\CNUserFunc::checkUser('email', $email)){
                return \cpn\chanpan\classes\CNMessage::getError("Email {$email} ถูกใช้งานแล้ว");
            }
            
            
            if($user->save()){
                $profile = new Profile();
                $profile->user_id = $user->id;
                $profile->name = "{$post['firstname']} {$post['lastname']}";
                $profile->firstname = $post['firstname'];
                $profile->lastname = $post['lastname'];
                if($profile->save()){
                    return \cpn\chanpan\classes\CNMessage::getSuccess("เพิ่มผู้ใช้งานสำเร็จ");
                }
            }
            
        }
        return $this->render('create', [
            'model'  => $model,
        ]);
    }
    
    
}
