<?php
namespace cpn\chanpan\helpers;
 
class CNHtml {
    public static function getMsgSuccess() {
        return '<strong><i class="glyphicon glyphicon-ok-sign"></i> Success!</strong> ';
    }

    public static function getMsgError() {
        return '<strong><i class="glyphicon glyphicon-warning-sign"></i> Error!</strong> ';
    }

    public static function getMsgWarning() {
        return '<strong><i class="glyphicon glyphicon-warning-sign"></i> Warning!</strong> ';
    }

    public static function getBtnAdd() {
        return '<span class="glyphicon glyphicon-plus"></span>';
    }

    public static function getBtnDelete() {
        return '<span class="glyphicon glyphicon-minus"></span>';
    }

    public static function getBtnRepeat() {
        return '<span class="glyphicon glyphicon-repeat"></span>';
    }

    public static function getBtnSearch() {
        return '<span class="glyphicon glyphicon-search"></span>';
    }

}
