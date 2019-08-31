<?php

 
namespace cpn\chanpan\assets\jrating;
 
class JRatingAsset extends \yii\web\AssetBundle{
    public $sourcePath='@cpn/chanpan/assets/jrating/assets';
    public $css = [
        'themes/bootstrap-stars.css',
    ];
    public $js = [
        'jquery.barrating.min.js',
    ];
    public $depends=[
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
