<?php
use \Slim\Middleware\HttpBasicAuthentication\PdoAuthenticator;

$app->add(function($req, $res, $next){
    $return = $next($req, $res);

    $this->logger->info("Log content here");

    return $return;
});

$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    "path" => "/api",
    "realm" => "Protected",
    "authenticator" => new PdoAuthenticator([
        "pdo" => $container['pdo'],
        "table" => "users",
        "user" => "email",
        "hash" => "senha"
    ])
]));