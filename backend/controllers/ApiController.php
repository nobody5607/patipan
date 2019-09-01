<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\controllers;

use yii\web\UnauthorizedHttpException;

/**
 * Description of ApiController
 *
 * @author chanpan
 */
class ApiController extends \yii\web\Controller {

    private $user_id = null;

    public function beforeAction($action) {
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
    private function responseData($success = false, $data = []) {
        return [
            'success' => $success,
            'data' => $data
        ];
    }
    
    public function actionLogin(){
        $username = \Yii::$app->request->post('username');
        $password = \Yii::$app->request->post('password');
        
        $student = \backend\models\Student::find()->where('id=:id AND password=:password',[
            ':id'=>$username,
            ':password'=>$password
        ])->one();
         
        if(isset($student) && $student['password'] === $password){
             unset($student['password']);
             return $this->responseData(true, $student);
        }else{
            return $this->responseData(false, '');
        }
    }
    private function validateUser() {
        $message = "token require please login.";
        try {
            $token = \Yii::$app->request->headers->get('x-token');
            $student = \backend\models\Student::find()
                            ->where('token=:token', [':token' => $token])->one();
            if ($student) {
                $this->user_id = $student->id;
                return true;
            }
            return false;
        } catch (\yii\db\Exception $ex) {
            
        }
    }

    public function actionGetData() {
        if ($this->validateUser() === false) {
            return $this->responseData(false, "Invalid token.");
        }
        $param = \Yii::$app->request->get('params', '');
        $data = isset(\Yii::$app->params[$param]) ? \Yii::$app->params[$param] : '';
        if ($data != '') {
            return $this->responseData(true, $data);
        }
    }

    public function actionGetLesson() {
        if ($this->validateUser() === false) {
            return $this->responseData(false, "Invalid token.");
        }
        $term = \Yii::$app->request->get('term', '');
        $lesson = \backend\models\Lessons::find()
                        ->where('name like :name', [':name' => "%{$term}%"])
                        ->orderBy(['forder' => SORT_ASC])->all();
        if ($lesson) {
            return $this->responseData(true, $lesson);
        }
    }

    public function actionGetLessonById($id) {
        if ($this->validateUser() === false) {
            return $this->responseData(false, "Invalid token.");
        }

        $lesson = \backend\models\Lessons::find()->where('id=:id', [':id' => $id])->orderBy(['forder' => SORT_ASC])->one();
        if ($lesson) {
            return $this->responseData(true, $lesson);
        }
    }
    
    public function actionGetTest() {
        if ($this->validateUser() === false) {
            return $this->responseData(false, "Invalid token.");
        }
        $type = \Yii::$app->request->get('type', '');
        $output = [];
        $test = \backend\models\Test::find()->where('type=:type',[':type'=>$type])->all();
        if ($test) {
            foreach($test as $k=>$v){
                $output[$k]= [
                    'id'=>$v->id,
                    'number'=>isset($v->number)?$v->number:'',
                    'question'=>isset($v->question)?$v->question:'',
                    'type'=>isset($v->type)?$v->type:'',
                    'answers'=>[]
                ];
                 $testChoice = \backend\models\TestChoice::find()->where('test_id=:id',[':id'=>$v['id']])->all();
                if($testChoice){
                    foreach($testChoice as $k2=>$v2){
                        $output[$k]['answers'][$k2] = [
                            'id'=>$v2['id'],
                            'test_id'=>$v2['test_id'],
                            'label'=>$v2['label'],
                            'value'=>$v2['value']
                        ];
                    }
                     
                }
               
            }
            return $this->responseData(true, $output);
        }
    }
    
    public function actionSaveTest() {
        if ($this->validateUser() === false) {
            return $this->responseData(false, "Invalid token."); 
        }
        
        $student = \backend\models\Student::findOne($this->user_id);
        
        $data = \Yii::$app->request->post('data');
        $type = \Yii::$app->request->post('type');
        $data = json_decode($data);
         
        
        $output = [];
        $totalScore=0;
        $totalWrongScore = 0;
        foreach($data as $k=>$v){
            $test = \backend\models\Test::find()
                    ->where('id=:id AND type=:type',[
                        ':id'=>$v->test_id, 
                        ':type'=>$type
                    ])->one();
            $testChoice = \backend\models\TestChoice::find()
                    ->where('test_id=:id AND label=:answer',[':id'=>$test->id,':answer'=>isset($test->answer)?$test->answer:''])->one();
            if(isset($test) && $test->answer === $v->label){
                //yes
                 $totalScore++;
                 $output['data'][$k]=[
                    'id'=>$v->id,
                    'number'=>isset($test->number)?$test->number:'', //ข้อที่
                    'question'=>isset($test->question)?$test->question:'',//คำถาม
                    'answer'=>isset($test->answer)?$test->answer:'', //คำตอบที่ถูกต้องเช่น ง
                    'value'=>isset($testChoice->value)?$testChoice->value:'',//รายละเอียดคำตอบ    
                    'score'=>1,//คะแนน
                    'yourAnswer'=>isset($v->label)?$v->label:'',//คำตอบของคุณ ก
                    'yourAnswerValue'=>isset($v->value)?$v->value:'',//รายละเอียดคำตอบของคุณ   
                ]; 
                
            }else{
                //no 
                $totalWrongScore++;
                $output['data'][$k]=[
                  'id'=>$v->id,
                  'number'=>isset($test->number)?$test->number:'',
                  'question'=>isset($test->question)?$test->question:'',  
                  'answer'=>isset($test->answer)?$test->answer:'', 
                  'value'=>isset($testChoice->value)?$testChoice->value:'',    
                  'score'=>0,
                  'yourAnswer'=>isset($v->label)?$v->label:'',  
                   'yourAnswerValue'=>isset($v->value)?$v->value:'', 
                   
                ];  
            }
        }
        $output['totalScore']      = $totalScore; //รวมคะแนนที่ถูกต้อง
        $output['totalWrongScore'] = $totalWrongScore;//รวมคะแนนที่ผิด
        $student->id = (string)$student->id;
        $student->rstat = 4;
        if($type == 1){
            $student->start_score = $output['totalScore'];
        }else{
            $student->end_score = $output['totalScore'];
        }
        if(!$student->save()){
            return $this->responseData(false, $student->errors);
        } 
        return $output;
        return $this->responseData(true, $student);
    }

    public function actionGetStudent() {
        if ($this->validateUser() === false) {
            return $this->responseData(false, "Invalid token."); 
        }
        
        $student = \backend\models\Student::findOne($this->user_id);
        if($student){
            return $this->responseData(true, $student);
        }else{
            return $this->responseData(false, []);
        }
   }

}
