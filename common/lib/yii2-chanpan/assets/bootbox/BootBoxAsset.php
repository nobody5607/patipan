<?php

namespace cpn\chanpan\assets\bootbox;

use yii\web\AssetBundle;

class BootBoxAsset extends AssetBundle {

	public $sourcePath = '@cpn/chanpan/assets/bootbox';
	public $css = [
	];
	public $js = [
		'js/bootbox.min.js',
		'js/confirm.js?995'
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
		'yii\bootstrap\BootstrapPluginAsset',
	];

}
