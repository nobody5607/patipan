<?php

namespace frontend\themes\market\assets;

use yii\web\AssetBundle;
class MarketAssets extends AssetBundle{
    public $sourcePath = '@frontend/themes/market/assets';
     public $css = [
        'font-awesome-4.7.0/css/font-awesome.min.css',
        'css/lib.css',
        'css/custom.css',
        'css/style.css',
        'css/animate.css',
        'css/owl.carousel.css',
        'css/shortcodes.css',
        'css/jquery.fancybox.css',
        'css/slider.css',
        'css/so-listing-tabs.css',
        'css/style_render_33.css',
        'css/style_render_35.css',
        'css/cookieconsent.min.css',
        'css/so_megamenu.css',
        'css/wide-grid.css',
        'css/so_searchpro.css',
        'css/so_sociallogin.css',
        'css/orange.css',
        'css/header1.css',
        'css/footer1.css',
        'css/responsive.css',
        'css/query-device.css'
    ];

    public $js = [
        'js/libs.js',
        //'js/so.system.js',    
        'js/jquery.sticky-kit.min.js',
        'js/lazysizes.min.js',    
        'js/so.custom.js',
        //'js/common.js',    
        'js/owl.carousel.js',
//        'js/shortcodes.js',
        'js/jquery.fancybox.js',
        'js/script.js',    
        'js/section.js',
        'js/modernizr.video.js',
        'js/swfobject.js',    
        'js/video_background.js',
        'js/script.js',
        'js/jquery.cookie.js',    
        'js/cookiemanager.js',
        'js/cookieconsent.min.js',    
        'js/so_megamenu.js'     
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset', 
    ];
}
