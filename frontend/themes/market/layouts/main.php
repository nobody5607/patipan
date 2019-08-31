<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

frontend\themes\market\assets\MarketAssets::register($this);

//AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <?php Yii::$app->meta->displaySeo() ?>
        <meta property="fb:app_id" content="177188695765715" />
        <meta property="og:locale" content="th_TH" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?= $this->title ?>" />
        <meta property="og:url" content="<?= \yii\helpers\Url::canonical() ?>" />
        <meta property="og:site_name" content="ProgrammerThailand.com" />
        <meta property="article:publisher" content="https://www.facebook.com/pgmtl/" />

        <meta name="twitter:card" content="summary"/>
        <meta name="twitter:title" content="<?= $this->title ?>"/>
        <meta name="twitter:site" content="ProgrammerThailand.com"/>
        <meta name="twitter:domain" content="https://xxx.com"/>


        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="common-home ltr layout-1 pattern-6">
        <?php $this->beginBody() ?>

        <div id="wrapper" class="wrapper-boxed banners-effect-3" >
            <header
                id="header"
                class="variant typeheader-1"
                >

                <div class="header-top hidden-compact cn-hidden-compact">
                    <div class="container">
                        <div class="row">
                            <div class="header-menu col-md-12">
                                <div class="responsive megamenu-style-dev">

                                    <nav class="navbar-default">
                                        <div class="container-megamenu   horizontal">
                                            <div class="navbar-header">
                                                <button
                                                    type="button"
                                                    id="show-megamenu"
                                                    data-toggle="collapse"
                                                    class="navbar-toggle"
                                                    style="margin-left: 10px;"
                                                    >
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                                
                                            </div>
                                             
                                            <div class="navbar-header">
                                                <button type="button" id="show-verticalmenu" data-toggle="collapse" class="navbar-toggle">
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                            </div>

                                            <div class="megamenu-wrapper">

                                                <span
                                                    id="remove-megamenu"
                                                    class="fa fa-times"
                                                    ></span>

                                                <div class="megamenu-pattern">
                                                    <div class="container">
                                                        <ul class="megamenu pull-right" data-transition="slide" data-animationtime="500" >
                                                            <li>
                                                                <a href="#">
                                                                    <span>
                                                                        <strong>สิทธิประโยชน์</strong>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#">
                                                                    <span>
                                                                        <strong>วิธีการสั่งซื้อ</strong>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#">
                                                                    <span>
                                                                        <strong>สำหรับผู้รับเหมา</strong>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#">
                                                                    <span>
                                                                        <strong>สำหรับเจ้าของบ้าน</strong>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#">
                                                                    <span>
                                                                        <strong>ร้านค้า</strong>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#">
                                                                    <span>
                                                                        <strong>โรงงาน</strong>
                                                                    </span>
                                                                </a>
                                                            </li>  
                                                            <li>
                                                                <a href="#">
                                                                    <span>
                                                                        <strong>สำหรับรถขนส่ง</strong>
                                                                    </span>
                                                                </a>
                                                            </li>   
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </nav>
                                </div>

                            </div>  
                        </div>
                    </div>
                </div>

                <div class="header-middle">
                    <div class="container">
                        <div class="row">
                            <div class="navbar-logo col-lg-1 col-md-2 col-sm-2 col-xs-12 text-right">
                                <div class="logo">
                                    <a href="http://opencart.opencartworks.com/themes/so_supermarket/index.php?route=common/home">
                                        <img
                                            class="lazyautosizes lazyloaded"
                                            data-sizes="auto"
                                            src="https://www.onestockhome.com/assets/base/logos/osh-logo@2x-1d1f5faed226006e3fc1f19be207408b636b9283bc5c8258d77d40f000896889.png"
                                            data-src="https://www.onestockhome.com/assets/base/logos/osh-logo@2x-1d1f5faed226006e3fc1f19be207408b636b9283bc5c8258d77d40f000896889.png"
                                            title="Your Store"
                                            alt="Your Store"
                                            sizes="202px"
                                            >
                                    </a>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 responsive-device">
                                <div style="displey:flex;">
                                    <ul class="megamenu two-menu cn-menu" data-transition="slide" data-animationtime="500" >
                                        <li class>
                                            <a href="http://opencart.opencartworks.com/themes/so_supermarket/index.php?route=common/home">
                                                <span>
                                                    <strong>สินค้าทุกหมวดหมู่</strong>
                                                </span>
                                            </a>
                                        </li>
                                        <li class>
                                            <a href="http://opencart.opencartworks.com/themes/so_supermarket/index.php?route=common/home">
                                                <span>
                                                    <strong>สินค้าทุกแบรนด์</strong>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-2 cn-search">
                                <div class="search-header-w">
                                    <div class="icon-search hidden-lg hidden-md hidden-sm">
                                        <i class="fa fa-search"></i>
                                    </div>

                                    <div
                                        id="sosearchpro"
                                        class="sosearchpro-wrapper so-search"
                                        >

                                        <form
                                            method="GET"
                                            action="index.php"
                                            >
                                            <div
                                                id="search0"
                                                class="search input-group form-group"
                                                >

                                                <input
                                                    class="autosearch-input form-control"
                                                    type="search"
                                                    value
                                                    size="50"
                                                    autocomplete="off"
                                                    placeholder="ค้นหาสินค้า"
                                                    name="search"
                                                    >

                                                <button
                                                    type="submit"
                                                    class="button-search btn btn-default btn-lg"
                                                    name="submit_search"
                                                    >
                                                    <i class="fa fa-search"></i>
                                                    <span>Search</span>
                                                </button>

                                            </div>

                                            <input
                                                type="hidden"
                                                name="route"
                                                value="product/search"
                                                >
                                        </form>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 cn-cart">
                                <div class="shopping_cart">
                                    <div
                                        id="cart"
                                        class="btn-shopping-cart"
                                        >

                                        <a
                                            data-loading-text="Loading..."
                                            class="btn-group top_cart dropdown-toggle"
                                            data-toggle="dropdown"
                                            >
                                            <div class="shopcart">
                                                <span class="icon-c">
                                                    <i class="fa fa-shopping-bag"></i>
                                                </span>
                                                <div class="shopcart-inner">
                                                    <p class="text-shopping-cart">My cart</p>

                                                    <span class="total-shopping-cart cart-total-full">
                                                        <span class="items_cart">0</span>
                                                        <span class="items_cart2">item(s)</span>
                                                        <span class="items_carts">( $0.00 )</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>


                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                    
                </div> 
                
                
                
            </header>
            
            <div id="content" class="container">
                 <?= $content;?>
            </div>
            
        </div>
        
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
