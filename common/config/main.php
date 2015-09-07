<?php
use common\models\Role;

return [
    'name' => 'Yello',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
        'v2' => [
            'class' => 'api\modules\v2\Module',
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager'=>array(
            'enablePrettyUrl'=>true,
            'enableStrictParsing' => false,
            'showScriptName'=>false,
            'rules'=>array(
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/shift',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v2/shift',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/user',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/store',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/image',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/requestReview',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/ShiftState',
                    ],
                ],

                'images/store/logo/<id:\d+>' => 'images/store-logo',
                'images/company/logo/<id:\d+>' => 'images/company-logo',
                'images/<action>/<id:\d+>' => 'images/<action>',

                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),
        'authManager' => [
            'class'          => 'yii\rbac\DbManager',
            'defaultRoles' => [
                Role::ROLE_EMPLOYEE,
                Role::ROLE_DRIVER,
                Role::ROLE_FRANCHISER,
                Role::ROLE_MANAGER,
                Role::ROLE_STORE_OWNER,
                Role::ROLE_SUPER_ADMIN,
                Role::ROLE_USER,
                Role::ROLE_YELLO_ADMIN
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
        'transport' => [
             'class' => 'Swift_SmtpTransport',
             'host' => 'smtp.mandrillapp.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
             'username' => 'steve@driveyello.com',
             'password' => 'e7c09BIEVFQb8vkz9hJshQ',
             'port' => '587', // Port 25 is a very common port too
             'encryption' => 'tls', // It is often used, check your provider or mail server specs
             ]               

//        'transport' => [
//             'class' => 'Swift_SmtpTransport',
//             'host' => 'email-smtp.us-east-1.amazonaws.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
//             'username' => 'AKIAJ4CNIEYSP6UPPBXA',
//             'password' => 'AkDyihIj/BOGV7uRM7k8I7zk+usYSv7ub4tGT5PEcfA/',
//             'port' => '587', // Port 25 is a very common port too
//             'encryption' => 'tls', // It is often used, check your provider or mail server specs
//             ]              
            
            
            ,
        ],

        'formatter' => [
            'class' => 'common\components\Formatter',
            'timeZone' => 'UTC'
        ],
        'activity' => [
            'class' => 'common\components\Activity'
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'forceCopy' => YII_DEBUG,
        ],
        'storage' => [
            'class' => '\jovanialferez\yii2s3\AmazonS3',
            'key' => 'AKIAID3OZY6UNFSSIWJA',
            'secret' => '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',
            'bucket' => 'media.driveyello.com',
        ],
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'console\controllers\FixtureController',
        ],
    ],
];
