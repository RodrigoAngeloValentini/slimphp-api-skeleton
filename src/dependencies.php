<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

//pdo
$container['pdo'] = function ($c) {
    $settings = $c->get('settings')['pdo'];
    return new \PDO($settings['dsn'],$settings['user'],$settings['password']);
};

//classes
$container['Api\Empresa\EmpresaController'] = function($c){
    return new Api\Empresa\EmpresaController($c);
};

$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        return $c['response']
            ->withStatus(405)
            ->withHeader('Content-type', 'application/json')
            ->write(json_encode(array('status'=>false,'message'=>'Method must be one of: ' . implode(', ', $methods)), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    };
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']
            ->withStatus(405)
            ->withHeader('Content-type', 'application/json')
            ->write(json_encode(array('status'=>false,'message'=>'Page not Found'), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    };
};
