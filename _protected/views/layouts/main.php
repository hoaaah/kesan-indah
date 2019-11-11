<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css'>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php  
    NavBar::begin([
        'brandLabel' => Yii::t('app', Yii::$app->name),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            // 'class' => 'navbar-default navbar-fixed-top',
            'class' => ['navbar-dark', 'bg-dark', 'navbar-expand-md']
        ],
    ]);

    // everyone can see Home page
    $menuItems[] = ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']];

    // we do not need to display About and Contact pages to employee+ roles
    if (!Yii::$app->user->can('employee')) {
        $menuItems[] = ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']];
        $menuItems[] = ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']];
    }

    // display Users to admin+ roles
    if (Yii::$app->user->can('admin')){
        $menuItems[] = ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']];
    }
    
    // display Logout to logged in users
    if (!Yii::$app->user->isGuest) {
        function akses($menu){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => $menu])->one();
            IF($akses){
                return true;
            }else{
                return false;
            }
        }
        $menuItems[] = ['label' => 'Jenis Persediaan', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => !Yii::$app->user->isGuest, 'items' => 
            [
                ['label' => 'Klasifikasi Akun', 'icon' => 'circle-o', 'url' => ['/klasifikasi/akun'], 'visible' => akses(501)],
                ['label' => 'Item', 'icon' => 'circle-o', 'url' => ['/klasifikasi/item'], 'visible' => akses(502)],
            ],
        ];
        $menuItems[] = ['label' => 'Transaksi Persediaan', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => !Yii::$app->user->isGuest, 'items' => 
            [
                ['label' => 'Pembelian', 'icon' => 'circle-o', 'url' => ['/transaksi/purchase'], 'visible' => akses(501)],
                ['label' => 'Akuisisi', 'icon' => 'circle-o', 'url' => ['/transaksi/akuisisi'], 'visible' => akses(502)],
            ],
        ];
        $menuItems[] = ['label' => 'Penggunaan Persediaan', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => !Yii::$app->user->isGuest, 'items' => 
            [
                ['label' => 'Saldo Awal', 'icon' => 'circle-o', 'url' => ['/usage/saldoawal'], 'visible' => akses(501)],
                ['label' => 'Pemindahan Persediaan', 'icon' => 'circle-o', 'url' => ['/usage/move'], 'visible' => akses(502)],
                ['label' => 'Acceptance Pemindahan', 'icon' => 'circle-o', 'url' => ['/usage/accept-move'], 'visible' => akses(502)],
                ['label' => 'Penggunaan', 'icon' => 'circle-o', 'url' => ['/usage/usage'], 'visible' => akses(502)],
            ],
        ];
        $menuItems[] = ['label' => 'Pembukuan', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => !Yii::$app->user->isGuest, 'items' => 
            [
                ['label' => 'Tutup Buku', 'icon' => 'circle-o', 'url' => ['/reporting/closing'], 'visible' => akses(501)],
                ['label' => 'Laporan Tahunan', 'icon' => 'circle-o', 'url' => ['/reporting/report'], 'visible' => akses(502)],
            ],
        ];
        $menuItems[] = [
            'label' => Yii::t('app', 'Logout'). ' (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }

    // display Signup and Login pages to guests of the site
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
        $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    }

    echo Nav::widget([
        // 'options' => ['class' => 'navbar-nav navbar-right'],
        'options' => ['class' => 'navbar-nav ml-auto'],
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
        <p class="pull-left">&copy; <?= Yii::t('app', Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
