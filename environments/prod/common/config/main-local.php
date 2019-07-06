<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=yelloau.cquajeb46vrk.ap-southeast-2.rds.amazonaws.com;dbname=driveprod1',
            'username' => 'driveprodusr',
            'password' => 'Ru553lf@irf@x',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
        'transport' => [
             'class' => 'Swift_SmtpTransport',
             'host' => 'email-smtp.us-east-1.amazonaws.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
             'username' => 'AKIAJ4CNIEYSP6UPPBXA',
             'password' => 'AkDyihIj/BOGV7uRM7k8I7zk+usYSv7ub4tGT5PEcfA/',
             'port' => '587', // Port 25 is a very common port too
             'encryption' => 'tls', // It is often used, check your provider or mail server specs
             ]            
            ,
        ],
    ],
];
