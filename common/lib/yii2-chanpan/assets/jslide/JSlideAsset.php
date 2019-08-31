<?php

 
namespace cpn\chanpan\assets\jslide;
 
class JSlideAsset extends \yii\web\AssetBundle{
    public $sourcePath='@cpn/chanpan/assets/jslide/assets';
    public $css = [
        'css/jslide.css',
        'jlightbox/assets/css/lightgallery.css'
    ];
    public $js = [
        'js/jssor.slider.min.js',
        'js/jslide.js',
        'jlightbox/assets/js/lightgallery-all.min.js'
    ];
    public $depends=[
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
