<?php
use \Psr\Http\Message\ServerRequestInterface as Req;
use \Psr\Http\Message\ResponseInterface as Resp;

require '../../vendor/autoload.php';

$app = new \Slim\App;
$app->get('/', function (Req $req, Resp $resp, array $args){
    $resp->getBody()->write("Hello gabriel");
});
$app->get('/{name}', function (Req $req, Resp $resp, array $args) {
    $name = $args['name'];
    $resp->getBody()->write("Hello, $name");

    return $resp;
});
$app->post('/', function () use ($app) {
    $nome = $app->Req()->getBody();
    echo "hello $nome";
});

$app->run();
?>
