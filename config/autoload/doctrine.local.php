<?php

declare(strict_types=1);

use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'driver' => 'pdo_mysql',
                    'host' => 'acsi-dev-mysql',
                    'port' => '3306',
                    'user' => 'root',
                    'password' => 'b3unh44s',
                    'dbname' => 'laminas',
                    'charset' => 'utf8',
                ],
            ],
        ],
    ],
];
