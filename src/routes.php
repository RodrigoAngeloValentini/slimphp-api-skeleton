<?php
// Routes
$app->get('/', function ($request, $response, $args) {
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->group('/api',function() {

    $this->get('/empresa',function($request,$response, $args){

        $pdo = $this->pdo;

        $stmt = $pdo->prepare("SELECT * FROM empresas");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //$response = $response->withHeader('Content-Type', 'application/json');
        //$response->getBody()->write(json_encode($result, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        $response = $response->withJson($result,200);

        return $response;

    });

    $this->get('/empresa-class','Api\Empresa\EmpresaController:index');
});

