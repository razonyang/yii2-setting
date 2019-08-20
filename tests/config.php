<?php

return [
    'id' => 'test',
    'basePath' => __DIR__,
    'controllerMap' => [
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationNamespaces' => [
                'RazonYang\Yii2\Setting\Migration',
            ],
        ],
    ],
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
            'cachePath' => __DIR__ . '/_output/cache',
        ],
        'mutex' => [
            'class' => \yii\mutex\FileMutex::class,
            'mutexPath' => __DIR__ . '/_output/mutex',
        ],
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=test',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
        ],
        'settingManager' => [
            'class' => \RazonYang\Yii2\Setting\DbManager::class,
        ],
    ],
];
