<?php

namespace Api\Empresa;

use Interop\Container\ContainerInterface;

class EmpresaController{

    protected $ci;
    //Constructor
    public function __construct(ContainerInterface $ci) {
        $this->ci = $ci;
    }

    public function index($request, $response, $args){

        $pdo = $this->ci->get('pdo');

        $stmt = $pdo->prepare("SELECT * FROM empresas");
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $response = $response->withJson($result,200);

        $logger = $this->ci->get('logger');
        $logger->info("Route: /api/empresa-class - Response :{$response}");

        return $response;
    }
}