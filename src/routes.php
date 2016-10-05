<?php
$container = $app->getContainer();
$container['Api\Empresa\EmpresaController'] = function($c){
  return new Api\Empresa\EmpresaController($c);
};
// Routes
$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->group('/api',function() {

    $this->get('/empresa',function($request,$response, $args){

        $pdo = $this->pdo;

        $stmt = $pdo->prepare("SELECT * FROM empresas");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = $response->withJson($result,200);
        $this->logger->info("Route: /api/empresa - Response :{$response}");

        return $response;

    });

    $this->get('/empresa-class','Api\Empresa\EmpresaController:index');
});

