<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\controllers;

use appxq\sdii\utils\VarDumper;
use backend\models\Lessons;
use backend\models\Student;
use common\modules\user\models\Profile;
use common\modules\user\models\User;
use yii\web\UnauthorizedHttpException;

/**
 * Description of ApiController
 *
 * @author chanpan
 */
class ApiController extends \yii\web\Controller
{

    private $user_id = null;
    public function beforeAction($action)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: DELETE, POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With,x-token');
        \Yii::$app->controller->enableCsrfValidation = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     *
     * @param type $success boolean
     * @param type $data array|object
     * @return type array
     */
    private function responseData($success = false, $data = [])
    {
        return [
            'success' => $success,
            'data' => $data
        ];
    }
    private function validateUser($token){
        $user = Student::find()->where('token=:token',[
            ':token' => $token
        ])->one();
        if($user){
            return true;
        }
        return false;
    }
    public function actionLogin()
    {
        $username = \Yii::$app->request->post('username');
        $password = \Yii::$app->request->post('password');
        $output = [];
        $user = Student::find()->where('id=:id AND password=:password',[
            ':id'=>$username,
            ':password' => $password
        ])->one();

        if ($user) {
            if ($user) {
                return $this->responseData(true, $user);
            }else{
                return $this->responseData(false, []);
            }
        }
    }
    public function actionLesson()
    {
        $token = \Yii::$app->request->get('token', '');
        if ($this->validateUser($token) === false) {
            return $this->responseData(false, "Invalid token.");
        }
        $term = \Yii::$app->request->get('term', '');
        $lesson = Lessons::find()
            ->where('name like :name AND rstat not in(0,3)', [':name' => "%{$term}%"])
            ->orderBy(['forder' => SORT_ASC])->all();
        if ($lesson) {
            return $this->responseData(true, $lesson);
        }
    }
    public function actionLessonById()
    {
        $token = \Yii::$app->request->get('token', '');
        if ($this->validateUser($token) === false) {
            return $this->responseData(false, "Invalid token.");
        }
        $id = \Yii::$app->request->get('id', null);
        $lesson = Lessons::findOne($id);
        if ($lesson) {
            return $this->responseData(true, $lesson);
        }
    }


}
