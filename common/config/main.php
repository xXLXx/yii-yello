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
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),
        'authManager' => [
            'class'          => 'yii\rbac\PhpManager',
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
            'itemFile'       => '@common/rbac/items.php',
            'assignmentFile' => '@common/rbac/assignments.php',
            'ruleFile'       => '@common/rbac/rules.php'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'yelloyellodev@gmail.com',
                'password' => 'yello1234567',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'formatter' => [
            'class' => 'common\components\Formatter',
            'timeZone' => 'Australia/Sydney'
        ],
        'activity' => [
            'class' => 'common\components\Activity'
        ]
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'console\controllers\FixtureController',
        ],
    ],
];
