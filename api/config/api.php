<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//$params = require(__DIR__ . '/params.php');
 
$config = [
    'id' => 'api',
    'basePath'  => dirname(__DIR__).'/..',
    'bootstrap'  => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/api/modules/v1', // base path for our module class
            'class' => 'app\api\modules\v1\Api', // Path to module class
        ]
    ],
     
    
    'components'  => [
        // URL Configuration for our API
        'sms' => [
            'class' => 'Zelenin\yii\extensions\Sms',
            'api_id' => '4C802C87-E702-B6CC-E1F3-AC9DB115467E',
            'login' => '89539263080',
            'password' => 'faraway_3080'
        ],
        'urlManager'  => [
            'enablePrettyUrl'  => true,
            'showScriptName'  => false,
            'enableStrictParsing' => false,
            'rules' => [
                [
                    'class'  => 'yii\rest\UrlRule',
                    'controller'  => [
                        'v1/service',
                    ],
                    'except' => ['delete', 'update', 'create'],
                ],
                [
                    'class'  => 'yii\rest\UrlRule',
                    'controller'  => [
                        'v1/profile',
                    ],
                    'except' => ['delete'],
                ],
                [
                    'class'  => 'yii\rest\UrlRule',
                    'controller'  => [
                        'v1/signup',
                    ],
                    'except' => ['delete', 'view', 'update'],
                ],
                [
                    'class'  => 'yii\rest\UrlRule',
                    'controller'  => [
                        'v1/main',
                    ],
                ],
                [
                    'class'  => 'yii\rest\UrlRule',
                    'controller'  => [
                        'v1/rel-profile-section',
                        'v1/rel-profile-service',
                        'v1/rel-profile-spec',
                        'v1/profile-avatar',
                        'v1/profile-portfolio-item',
                    ],
                ],
                
            ],
        ],
        'request' => [
            // Set Parser to JsonParser to accept Json in request
            //'class' => '\yii\web\Request',
            'enableCookieValidation' => false,

            'parsers' => [
                'application/json'  => 'yii\web\JsonParser',
            ]

              
             
             
            
        ],
        'cache'  => [
            'class'  => 'yii\caching\FileCache',
        ],
        // Set this enable authentication in our API
        'user' => [
            'identityClass'  => 'app\models\User',
            'enableAutoLogin'  => false, 
            //'loginUrl' => null,
        ],
        // Enable logging for API in a api Directory different than web directory
        'log' => [
            'traceLevel'  => YII_DEBUG ? 3 : 0,
            'targets'  => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels'  => ['error'],//, 'warning'],
                    // maintain api logs in api directory
                    'logFile'  => '@api/runtime/logs/error.log'
                ],
            ],
        ],
        'db'  => require(__DIR__ . '/../../config/db.php'),
    ],
    //'params'  => $params,
];
 
return $config;