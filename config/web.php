<?php

use app\models\IpInfo;
use yii\helpers\Url;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU', // Язык приложения
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'layout' => 'main.twig',
    'defaultRoute' => 'ip-info',
    'components' => [
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        // Константы
                        'ADD_BTN_STR' => 'Добавить',
                        'SAVE_BTN_STR' => 'Сохранить',
                        'IP_LIST_STR' => 'Список IP-адресов',
                        'IP_UPDATE_STR' => 'Обновление информации об IP-адресе',
                        'IP_ADD_STR' => 'Добавление IP-адреса',
                        'UPDATE_STR' => 'Обновление',
                        // Классы
                        'Yii' => ['class' => '\Yii'],
                        'NavBar' => ['class' => '\yii\bootstrap5\NavBar'],
                        'Nav' => ['class' => '\yii\bootstrap5\Nav'],
                        'Breadcrumbs' => ['\yii\bootstrap5\Breadcrumbs'],
                        'ActiveForm' => ['class' => '\yii\bootstrap5\ActiveForm'],
                        'LinkPager' => ['class' => '\yii\bootstrap5\LinkPager'],
                        'IpInfo' => ['class' => '\app\models\IpInfo'],
                        'Url' => ['class' => '\yii\helpers\Url'],
                        'ActionColumn' => ['class' => '\yii\grid\ActionColumn'],
                        'CustomGridView' => ['class' => '\app\widgets\CustomGridView'],
                        'SerialColumn' => ['class' => '\yii\grid\SerialColumn']
                    ],
                    'uses' => ['yii\bootstrap'],
                    'extensions' => [
                        \yii\twig\html\HtmlHelperExtension::class,
                    ],
                    'functions' => [
                        new \Twig\TwigFunction('urlCreator', function () {
                            return function ($action, IpInfo $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'ip' => $model->ip]);
                            };
                        })
                    ],
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'eMqi8IbChzep0rCcY-1S27FMnpR9P_fD',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
