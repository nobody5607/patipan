<?php

namespace cpn\chanpan\utils;

use yii\helpers\VarDumper;
use yii\helpers\Json;
use yii\base\InvalidParamException;
 
class CNUtils {
    public static function getCurrentIp() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    public static function array2String($arry) {
        $str = '';
        try {
            if (is_array($arry) && !empty($arry)) {
                $str = Json::encode($arry);
            }
        } catch (InvalidParamException $e) {
            $str = '';
        }

        return $str;
    }

    public static function strArray2String($strArry) {
        $str = '';
        if (isset($strArry) && $strArry !== '') {
            $value = self::str2Eval($strArry);
            if($value){
                $str = self::array2String($value);
            }
        }
        
        return $str;
    }

    public static function string2strArray($str) {
        $arry = self::string2Array($str);
        
        if (is_array($arry) && !empty($arry)) {
            return VarDumper::export($arry);
        }
        return NULL;
    }

    public static function array2strArray($arry) {
        if (is_array($arry)) {
            return VarDumper::export($arry);
        }
        return NULL;
    }

    public static function string2Array($str) {
        try {
            if(isset($str) && $str!=''){
                $arry = Json::decode($str);
            } else {
                $arry = [];
            }
        } catch (InvalidParamException $e) {
            $arry = [];
        }
        if (is_array($arry)) {
            //$arry = self::JsExpressionRender($arry);
            return $arry;
        }
        return [];
    }

    public static function string2ArrayJs($str) {
        $arry = self::string2Array($str);
        
        if (is_array($arry)) {
            $arry = self::JsExpressionRender($arry);
            return $arry;
        }
        return [];
    }

    public static function str2Eval($str) {
        if (isset($str) && $str !== '') {
            try {
                $value = eval("return $str;");
                return $value;
            } catch (\yii\base\Exception $e) {
                return FALSE;
            }
        }
        return FALSE;
    }

    public static function JsExpressionRender(&$arry) {
        foreach ($arry as $key => $value) {
            if (is_array($value)) {
                $arry[$key] = self::JsExpressionRender($value);
            } else {
                $str = substr($value, 0, 15);
                
                if (strpos($str, 'function') !== false) {
                    $arry[$key] = new \yii\web\JsExpression($value);
                } else {
                    $arry[$key] = $value;
                }
            }
        }
        return $arry;
    }

    public static function getMillisecTime() {
        list($t1, $t2) = explode(' ', microtime());
        $mst = str_replace('.', '', $t2 . $t1);

        return $mst;
    }
    
    public static function getCurrentPath() {
        $current = explode('?', \yii\helpers\Url::current());
        return $current[0];
    }

}
