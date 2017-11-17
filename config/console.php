<?php

/**
 * @link http://www.diemeisterei.de/
 *
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

use yii\console\controllers\MigrateController;

return [
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'audit' => 'bedezign\yii2\audit\commands\AuditController',
        'migrate' => [
            'class' => MigrateController::className(),
            'migrationPath' => [
                getenv('APP_MIGRATION_LOOKUP'),
                '@yii/rbac/migrations',
                '@yii/web/migrations',
                '@bedezign/yii2/audit/migrations',
                '@dektrium/user/migrations',
                '@hrzg/widget/migrations',
                '@dmstr/modules/contact/migrations',
                '@vendor/lajax/yii2-translate-manager/migrations',
                '@vendor/pheme/yii2-settings/migrations',
                '@vendor/dmstr/yii2-prototype-module/src/migrations',
                '@vendor/dmstr/yii2-pages-module/migrations',
                '@vendor/dmstr/yii2-redirect-module/migrations',
                '@vendor/dmstr/yii2-filefly-module/migrations',
            ],
        ],
        'translate' => 'lajax\translatemanager\commands\TranslatemanagerController',
        'resque' => 'hrzg\resque\commands\ResqueController',
        'rbac' => 'dektrium\rbac\commands\RbacController',
        'db' => [
            'class' => 'dmstr\console\controllers\MysqlController',
            'noDataTables' => [
                getenv('DATABASE_TABLE_PREFIX').'auth_assignment',
                getenv('DATABASE_TABLE_PREFIX').'migration',
                getenv('DATABASE_TABLE_PREFIX').'user',
                getenv('DATABASE_TABLE_PREFIX').'profile',
                getenv('DATABASE_TABLE_PREFIX').'token',
                getenv('DATABASE_TABLE_PREFIX').'social_account',
                getenv('DATABASE_TABLE_PREFIX').'log',
                getenv('DATABASE_TABLE_PREFIX').'session',
                getenv('DATABASE_TABLE_PREFIX').'audit_data',
                getenv('DATABASE_TABLE_PREFIX').'audit_entry',
                getenv('DATABASE_TABLE_PREFIX').'audit_error',
                getenv('DATABASE_TABLE_PREFIX').'audit_javascript',
                getenv('DATABASE_TABLE_PREFIX').'audit_mail',
                getenv('DATABASE_TABLE_PREFIX').'audit_trail',
            ],
        ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                // writes to php-fpm output stream
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/console.log',
                    //'levels' => ['info', 'trace'],
                    'logVars' => [],
                    'enabled' => YII_DEBUG && !YII_ENV_TEST,
                ],
            ],
        ],
    ],
];
