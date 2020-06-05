<?php


$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

       'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                   'class' => 'yii\rest\UrlRule',
                   'controller' => 'apprest/country',
                   'pluralize' => false,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'apprest/chef',
                    'pluralize' => false,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'apprest/comment',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET allcomments' => 'allcomments',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'apprest/experience-type',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET experiences-country' => 'experiences-country',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'apprest/order',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET allorder' => 'allorder',
                        'POST addorder' => 'addorder',
                        'DELETE delorder' => 'delorder',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'apprest/payment',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET allpayment' => 'allpayment',
                        'POST addpayment' => 'addpayment',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'apprest/user',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET allusers' => 'allusers',
                        'POST adduser' => 'adduser',
                        'POST validlogin' => 'validlogin',
                        'PUT tokenuser' => 'tokenuser',
                        'POST passreset' => 'passreset',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'apprest/user-profile',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET showusers' => 'showusers',
                        'PUT edituserprofile' => 'edituserprofile',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'apprest/likes',
                    'pluralize' => false,
                ],
            ]

        ]

    ],
    'params' => $params, //Depois de $params,
    'modules' =>
        [
            'apprest' =>
                [
                    'class' => 'frontend\modules\apprest\Apprest',
                ],
        ],
];
