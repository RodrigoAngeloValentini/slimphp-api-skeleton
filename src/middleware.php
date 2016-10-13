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
    ]),
    "error" => function ($request, $response, $arguments) {
        $data = [];
        $data["status"] = "false";
        $data["message"] = $arguments["message"];
        return $response
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
]));

//$app->add(new \Slim\Middleware\JwtAuthentication([
//    "path" => "/api",
//    "secret" => "mysecretkey",
//    "secure" => false,
//    "error" => function ($request, $response, $arguments) {
//        $data["status"] = false;
//        $data["message"] = $arguments["message"];
//        return $response
//            ->withHeader("Content-Type", "application/json")
//            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
//    }
//]));