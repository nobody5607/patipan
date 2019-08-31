<?php

namespace cpn\chanpan\assets\highcharts;

use yii\web\AssetBundle;

class HighchartsAsset extends AssetBundle {

	public $sourcePath = '@cpn/chanpan/assets/highcharts';
	public $css = [
	];
	public $js = [
		'js/highcharts.js',
                'js/exporting.js',
		'js/export-data.js'
	];
	public $depends = [
		//'yii\web\YiiAsset',
		//'yii\bootstrap\BootstrapAsset',
		//'yii\bootstrap\BootstrapPluginAsset',
	];

}
