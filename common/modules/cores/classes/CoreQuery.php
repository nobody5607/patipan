<?php
namespace common\modules\cores\classes;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreQuery
 *
 * @author chanpan
 */
class CoreQuery {
    //put your code here
    public static function getOptionsParams() {
	$model = \common\models\CoreOptions::find()
		->select('option_name, option_value')
		->all();
        if($model){
            $params = \yii\helpers\ArrayHelper::map($model, 'option_name', 'option_value');
            return $params;
        }
	return [];
    }
}
