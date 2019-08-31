<?php

 
namespace cpn\chanpan\assets\jlightbox;
 
class JLightBoxAsset extends \yii\web\AssetBundle{
    public $sourcePath='@cpn/chanpan/assets/jlightbox/assets';
    public $css = [
        'css/lightgallery.css'
    ];
    public $js = [
        'js/lightgallery-all.min.js'         
    ];
    public $depends=[
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
