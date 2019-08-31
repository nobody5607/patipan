<?php


namespace frontend\modules\products\classes;
class CNProducts {
    //put your code here
    public static  function getBrandById($branId){
        $brands = \common\models\StockBrand::find()->where(['id'=>$branId,'deleted'=>'10'])->one();
        return $brands;
    }
    public static  function getCategorys($cateId){
        $categorys = \common\models\StockCategory::find()->where(['id'=>$cateId,'deleted'=>'10'])->one();
        return $categorys;
    }
    public static  function getProductGroup(){
        $productGroups = \common\models\StockProductGroup::find()->where(['deleted'=>'10'])->all();
        return $productGroups;
    }
    public static  function getProductGroupById($id){
        $productGroups = \common\models\StockProductGroup::find()->where(['id'=>$id,'deleted'=>'10'])->one();
        return $productGroups;
    }
}
