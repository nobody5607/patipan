<?php

namespace cpn\chanpan\assets\simplebar;

class SimpleBarAsset extends \yii\web\AssetBundle {

    public $sourcePath = '@cpn/chanpan/assets/simplebar';
    public $css = [
        'jquery.scrollbar.css',
    ];
    public $js = [
        'jquery.scrollbar.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
