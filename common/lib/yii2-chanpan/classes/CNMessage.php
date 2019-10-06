<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace cpn\chanpan\classes;
use Yii;
class CNMessage {
    public static function JsonResponses(){
        return \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public static function getSuccess($message, $data=[]) {
        self::JsonResponses();
         
        $result = [
            'data'=>$data,
            'status' => 'success',
            'action' => 'create',
            'message' => Yii::t('app', $message),
        ];
        return $result;
    }
    public static function getError($message, $data=[]) {
        self::JsonResponses(); 
        $result = [
            'status' => 'error',
            'action' => 'create',
            'message' =>Yii::t('app', $message),
            'data'=>$data
        ];
        return $result;
    }

}
