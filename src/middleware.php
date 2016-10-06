<?php
$app->add(function($req, $res, $next){
    $return = $next($req, $res);

    $this->logger->info("Log content here");

    return $return;
});