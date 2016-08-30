<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Sistema de Emissão de Pedidos',
    'import' => array(
        'models.*'
    ),
    'theme' => array(
        'name' => 'pedidos',
        'template' => 'index'
    ),
    'mad' => array(
        'module' => "",
        'access' => "acesso",
        'group' => "grupo",
        'log' => "log",
        'session' => "sessao",
        'transaction' => "transacao",
        'user' => "usuario"
    ),
    'login' => array(
        'module' => "",
        'class' => "MAuthDbMd5",
        'check' => false,
        'shared' => true,
        'auto' => false
    ),
    'db' => array(
        'db_pedidos' => array(
            'driver' => 'pdo_mysql',
            'host' => 'cursomaestro.ufjf.br',
            'dbname' => 'db_pedidos',
            'user' => 'root',
            'password' => '123456',
            'charset' => 'UTF8',
            'formatDate' => '%d/%m/%Y %T',
            'formatTimestamp' => '%d/%mm/%Y %T'
        ),
    ),
);
