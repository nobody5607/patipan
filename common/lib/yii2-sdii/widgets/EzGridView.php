<?php

namespace appxq\sdii\widgets;

use Yii;
use yii\helpers\Html;

/**
 * GridView class file UTF-8
 * @author SDII <iencoded@gmail.com>
 * @link http://www.appxq.com/
 * @copyright Copyright &copy; 2015 AppXQ
 * @license http://www.appxq.com/license/
 * @package appxq\sdii\widgets
 * @version 2.0.0 Date: Sep 5, 2015 3:18:34 PM
 * @example 
 */
class EzGridView extends \yii\grid\GridView {

	/**
	 * @var array the HTML attributes for the grid table element.
	 * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
	 */
	public $tableOptions = ['class' => 'table table-striped table-bordered table-hover'];
	public $responsiveTable = true;

	/**
	 * Initializes the widget.
	 */
	public function init() {
		parent::init();

			$items = ($this->responsiveTable) ? Html::tag('div', '{items}', ['class' => 'table-responsive']) : '{items}';
			$this->layout = <<<EOD
	    <div>
		{summary}
		$items
		{pager}
	    </div>	
EOD;
	}

}
