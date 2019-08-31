<?php

namespace cpn\chanpan\assets\jquery_scroll;

class JqueryScrollAsset extends \yii\web\AssetBundle {

    public $sourcePath = '@cpn/chanpan/assets/jquery_scroll';
    public $css = [
        
    ];
    public $js = [
        'dist/jquery.nicescroll.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
