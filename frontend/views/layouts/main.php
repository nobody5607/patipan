<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
\cpn\chanpan\assets\bootbox\BootBoxAsset::register($this);
\cpn\chanpan\assets\notify\NotifyAsset::register($this);

AppAsset::register($this);
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
    <meta name="twitter:domain" content="https://programmerthailand.com"/>
    
    
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        
        
        ['label' => 'Brand', 'url' => ['/products/stock-brand']],
        ['label' => 'Category', 'url' => ['/products/stock-category']],
        ['label' => 'Product Doc', 'url' => ['/products/stock-product-docs']],
        ['label' => 'Product Group', 'url' => ['/products/stock-product-group']],
        ['label' => 'Product Items', 'url' => ['/products/stock-product-items']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/user/registration/register']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/user/security/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
