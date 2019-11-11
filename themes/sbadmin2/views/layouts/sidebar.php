<?php

use hoaaah\sbadmin2\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;

function akses($menu){
    $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => $menu])->one();
    IF($akses){
        return true;
    }else{
        return false;
    }
}
$appName = Yii::$app->name;
$logoImage = Html::img(Url::to('@web/images/logo.png', false), ['height' => '30px']);
echo Menu::widget([
    'options' => [
        'ulClass' => "navbar-nav bg-gradient-primary sidebar sidebar-dark accordion",
        'ulId' => "accordionSidebar"
    ], //  optional
    'brand' => [
        'url' => ['/'],
        'content' => <<<HTML
            <div class="sidebar-brand-icon">
            $logoImage
            </div>
            <div class="sidebar-brand-text mx-3">{$appName}</sup></div>        
HTML
    ],
    'items' => [
        ['label' => 'Pengaturan', 'icon' => 'fas fa-circle','url' => '#', 'visible' => akses(102) || akses(103) || akses(104),'items'  =>
            [
                // ['label' => 'Pengaturan Global', 'icon' => 'fas fa-circle', 'url' => ['/management/setting'], 'visible' => akses(405)],
                ['label' => 'User Management', 'icon' => 'fas fa-circle', 'url' => ['/user/index'], 'visible' => akses(102)],
                ['label' => 'Akses Grup', 'icon' => 'fas fa-circle', 'url' => ['/management/menu'], 'visible' => akses(103)],
                ['label' => 'Blog/Pengumuman', 'icon' => 'fas fa-circle', 'url' => ['/management/pengumuman'], 'visible' => akses(104)],     
            ],
        ],                    
        ['label' => 'Parameter', 'icon' => 'fas fa-circle','url' => '#', 'visible' => akses(201) || akses(501) || akses(502),'items'  =>
            [
                ['label' => 'Informasi Unsur', 'icon' => 'fas fa-eye', 'url' => ['/parameter/info-unsur'], 'visible' => 202],
                ['label' => 'Unit-Divisi', 'icon' => 'fas fa-circle', 'url' => ['/parameter/unit'], 'visible' => akses(201)],
                ['label' => 'Klasifikasi Akun', 'icon' => 'fas fa-circle', 'url' => ['/klasifikasi/akun'], 'visible' => akses(501)],
                ['label' => 'Item', 'icon' => 'fas fa-circle', 'url' => ['/klasifikasi/item'], 'visible' => akses(502)],
            ],
        ],
        ['label' => 'Informasi Unsur', 'icon' => 'fas fa-eye', 'url' => ['/info-unsur'], 'visible' => 301],
        ['label' => 'Best Practice', 'icon' => 'fas fa-pen', 'url' => ['/best-practice'], 'visible' => 302],
        // ['label' => 'Penerimaan Persediaan', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => akses(404) || akses(402) || akses(403), 'items' => 
        //     [
        //         ['label' => 'Saldo Awal', 'icon' => 'fas fa-circle', 'url' => ['/usage/saldoawal'], 'visible' => akses(404)],
        //         ['label' => 'Pembelian', 'icon' => 'fas fa-circle', 'url' => ['/transaksi/purchase'], 'visible' => akses(402)],
        //         // ['label' => 'Akuisisi', 'icon' => 'fas fa-circle', 'url' => ['/transaksi/akuisisi'], 'visible' => akses(403)],
        //     ],
        // ],
        // ['label' => 'Penggunaan Persediaan', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => akses(411) || akses(405) || akses(408) || akses(407), 'items' => 
        //     [
        //         // ['label' => 'Acceptance Pemindahan', 'icon' => 'fas fa-circle', 'url' => ['/usage/permintaan-mutasi'], 'visible' => akses(411)],
        //         // ['label' => 'Pemindahan Persediaan', 'icon' => 'fas fa-circle', 'url' => ['/usage/move'], 'visible' => akses(405)],
        //         ['label' => 'Permintaan Pemakaian', 'icon' => 'fas fa-circle', 'url' => ['/usage/requestusage'], 'visible' => akses(408)],
        //         ['label' => 'Pemakaian', 'icon' => 'fas fa-circle', 'url' => ['/usage/usage'], 'visible' => akses(407)],
        //     ],
        // ],
        // ['label' => 'Pembukuan & Pelaporan', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => !Yii::$app->user->isGuest, 'items' => 
        //     [
        //         // ['label' => 'Tutup Buku', 'icon' => 'fas fa-circle', 'url' => ['/reporting/closing'], 'visible' => akses(503)],
        //         ['label' => 'Laporan', 'icon' => 'fas fa-circle', 'url' => ['/pelaporan/pelaporan'], 'visible' => akses(504)],
        //     ],
        // ],
    ]
]);