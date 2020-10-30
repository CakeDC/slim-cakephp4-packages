<?php
declare(strict_types=1);

use Cake\Core\Configure;
use DI\ContainerBuilder;
use Monolog\Logger;

Configure::write('App.namespace', 'App');

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // Should be set to false in production
            'logger' => [
                'name' => 'slim-app',
                'path' => __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'database' => [
                'className' => \Cake\Database\Connection::class,
                'driver' => \Cake\Database\Driver\Mysql::class,
                'database' => 'my_db',
                'username' => 'root',
                'password' => 'secret',
                'host' => 'mysql',
            ]
        ],
    ]);
};

