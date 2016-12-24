<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'UMKA',
    'name' => 'umka',
    'language' => 'ru-RU', 
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'sms' => [
            'class' => 'zelenin\yii\extensions\Sms',
            'api_id' => '4C802C87-E702-B6CC-E1F3-AC9DB115467E',
            'login' => '89539263080',
            'password' => 'faraway_3080'
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '0wE8G3QE1y-BYzRQ6z3eAfgffT',
            /*'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
             * 
             */
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],
        
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        // 
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
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
        'db' => require(__DIR__ . '/db.php'),
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        
    ],
    'modules' => [
        
        'rbac' =>  [
            'class' => 'johnitvn\rbacplus\Module'
        ],/*
        'v1' => [
            'basePath' => '@app/api/modules/v1', // base path for our module class
            'class' => 'app\api\modules\v1\Api', // Path to module class
        ],*/
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ]       
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

$config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
	'allowedIPs' => ['127.0.0.1', '::1']
    ];
}

return $config;
