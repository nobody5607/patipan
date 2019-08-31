<?php
namespace backend\classest;
use cpn\chanpan\utils\CNUtils;

class KNLogFunc {
    /**
     * 
     * @param type $type  1=log|2=error|integer
     * @param type $name  logname|string
     * @param type $detail array|string
     * @return boolean true|false
     */
    public static function addLog($type, $name, $detail){
       try{
           $model = new \backend\models\Systemlog();
           $model->id = \cpn\chanpan\utils\CNUtils::getMillisecTime();
           $model->logname = $name;
           $model->logtype = $type;
           $model->logdetail = $detail;
           $model->rstat = 1;
           $model->create_by = \common\modules\user\classes\CNUserFunc::getUserId();
           $model->create_date = date('Y-m-d H:i:s');
           $model->ip = CNUtils::getCurrentIp();
           if($model->save()){
               return true;
           }
       } catch (Exception $ex) {
        
       }
    }
}
