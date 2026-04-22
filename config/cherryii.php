<?php

return [
    'modules' => [
        'admin' => [
            'class' => 'yii\cherryii\AdminModule',
        ],
    ],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'admin/<controller:\w+>/<action:[\w-]+>/<id:\d+>' => 'admin/<controller>/<action>',
                'admin/<module:\w+>/<controller:\w+>/<action:[\w-]+>/<id:\d+>' => 'admin/<module>/<controller>/<action>'
            ],
         ],
        'user' => [
            'identityClass' => 'yii\cherryii\models\Admin',
            'enableAutoLogin' => true,
            'authTimeout' => 86400,
        ],
        'i18n' => [
            'translations' => [
                'cherryii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@cherryii/messages',
                    'fileMap' => [
                        'cherryii' => 'admin.php',
                    ]
                ]
            ],
        ],
        'formatter' => [
            'sizeFormatBase' => 1000
        ],
    ],
    'bootstrap' => ['admin']
];