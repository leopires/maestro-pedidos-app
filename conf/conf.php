<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Sistema de Emissão de Pedidos',
    'import' => array(
        'models.*'
    ),
    'theme' => array(
        'name' => 'default',
        'template' => 'index'
    ),
    'db' => array(
        'db_pedidos' => array(
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'db_pedidos',
            'user' => 'root',
            'password' => 'root',
            'charset' => 'UTF8',
            'formatDate' => '%d/%m/%Y %T',
            'formatTimestamp' => '%d/%mm/%Y %T'
        ),
    ),
);
