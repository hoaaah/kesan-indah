<?php

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'kesian',
    'name' => $params['anoAppName'] ? $params['anoAppName'] : 'Kesan Indah',
    'language' => 'id',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'app\components\Aliases'],    
    'modules' => [
        'gridview' => [
          'class' => '\kartik\grid\Module',
        ],
        'pdfjs' => [
            'class' => '\yii2assets\pdfjs\Module',
        ],
        'globalsetting' => [
            'class' => 'app\modules\globalsetting\globalsetting',
        ],
        'parameter' => [
            'class' => 'app\modules\parameter\parameter',
        ],
        'management' => [
            'class' => 'app\modules\management\management',
        ],   
        'pelaporan' => [
            'class' => 'app\modules\pelaporan\pelaporan',
        ],
    ],     
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '6P3eita9yBQbVSs-eyhwXx-mWZlHMFDx',
        ],
        // you can set your theme here - template comes with: 'light' and 'dark'
        'view' => [
            // theme for admin LTE
            'theme' => [
                // 'pathMap' => ['@app/views' => '@webroot/themes/adm/views'],
                // 'baseUrl' => '@web/themes/adm',
                'pathMap' => ['@app/views' => '@webroot/themes/sbadmin2/views'],
                'baseUrl' => '@web/themes/sbadmin2',
            ],      
        ],
        'assetManager' => [
            'bundles' => [
                // we will use bootstrap css from our theme
                // 'yii\bootstrap\BootstrapAsset' => [
                //     'css' => [], // do not use yii default one
                // ],
                /* Part ini adalah untuk mengganti skin admin-LTE. Ganti sesuai yang tersedia @hoaaah
                "skin-blue",
                "skin-black",
                "skin-red",
                "skin-yellow",
                "skin-purple",
                "skin-green",
                "skin-blue-light",
                "skin-black-light",
                "skin-red-light",
                "skin-yellow-light",
                "skin-purple-light",
                "skin-green-light"
                */
                // 'dmstr\web\AdminLteAsset' => ['skin' => 'skin-purple',],                
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<alias:\w+>' => 'site/<alias>',
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\UserIdentity',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_kesianUser', // unique for backend
                // 'path'=>'/backend/web'  // correct path for the backend app.
            ]                 
        ],
        'session' => [
            'name' => '_kesianSessionId', // unique for backend
            'class' => 'yii\web\Session',
            'savePath' => '@app/runtime/session'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. 
            // You have to set 'useFileTransport' to false and configure a transport for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/translations',
                    'sourceLanguage' => 'en',
                ],
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/translations',
                    'sourceLanguage' => 'en'
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'currencyCode' => 'Rp'
        ],
        'qr' => [
            'class' => '\Da\QrCode\Component\QrCodeComponent',
            // ... you can configure more properties of the component here
        ],   
        'db' => require(__DIR__ . '/db.php'),
    ],
    // this class use for force login to all controller. Usefull quiet enough
    // this function work only in login placed in site controller. FOr other login controller/action, change denyCallback access
	// 'as beforeRequest' => [
    //     'class' => 'yii\filters\AccessControl',
    //     'rules' => [
    //         [
    //             'allow' => true,
    //             'actions' => ['login', 'qr'],
    //         ],
    //         [
    //             'allow' => true,
    //             'roles' => ['@'],
    //         ],
    //     ],
    //     'denyCallback' => function () {
    //         return Yii::$app->response->redirect(['site/login']);
    //     },
    // ],    
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'panels' => [
            'user' => [
                'class'=>'yii\debug\panels\UserPanel',
                'ruleUserSwitch' => [
                    'allow' => true,
                    'roles' => ['@'],
                ]
            ]
        ],
        // uncomment and adjust the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],        
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = ['class' => 'yii\gii\Module'];
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        'generators' => [
            'crud'   => [
                'class'     => 'yii\gii\generators\crud\Generator',
                'templates' => ['modalcrud' => '@app/templates/modalcrud']
            ]
        ]
    ];    
}

return $config;
