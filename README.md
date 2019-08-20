Yii2 Setting Manager
====================

[![Build Status](https://travis-ci.org/razonyang/yii2-setting.svg?branch=master)](https://travis-ci.org/razonyang/yii2-setting)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/razonyang/yii2-setting/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/razonyang/yii2-setting/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/razonyang/yii2-setting/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/razonyang/yii2-setting/?branch=master)
[![Latest Stable Version](https://img.shields.io/packagist/v/razonyang/yii2-setting.svg)](https://packagist.org/packages/razonyang/yii2-setting)
[![Total Downloads](https://img.shields.io/packagist/dt/razonyang/yii2-setting.svg)](https://packagist.org/packages/razonyang/yii2-setting)
[![LICENSE](https://img.shields.io/github/license/razonyang/yii2-setting)](LICENSE)


Installation
------------

```
composer require razonyang/yii2-setting
```

Usage
-----

Configuration:

```php
return [
    // console
    'controllerMap' => [
        'migrate' => [
            'migrationNamespaces' => [
                'RazonYang\Yii2\Setting\Migration',
            ],
        ],
    ],

    'components' => [
        // common
        'settingManager' => [
            'class' => \RazonYang\Yii2\Setting\DbManager::class,
            'enableCache' => YII_DEBUG ? false : true,
            'cache' => 'cache',
            'mutex' => 'mutex',
            'duration' => 600,
            'db' => 'db',
            'settingTable' => '{{%setting}}',
        ],
    ],
];
```

Migration:

```
$ yii migrate
```

```php
$settingManager = Yii::$app->get('settingManager');

// fetch by ID
$value = $settingManager->get($id, $defaultValue); // defaultValue is optional

// fetchs all settings
$settings = $settingManager->getAll();

// flush cache
$settingManager->flushCache();
```