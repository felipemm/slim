<?php
// Application middleware
use Psr7Middlewares\Middleware\TrailingSlash;
use \Slim\Middleware\HttpBasicAuthentication\PdoAuthenticator;


$pdo = new \PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);



$app->add(new TrailingSlash(false));



/**
 * Auth básica HTTP
 */
$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    //"path" => ["/auth"],
    "path" => [$container->get('settings')['authRoute']],
    "secure" => true,
    "relaxed" => ["localhost", "devserver"],
    "authenticator" => new PdoAuthenticator([
        "pdo" => $pdo
    ])
]));


/**
 * Auth básica do JWT
 * Whitelist - Bloqueia tudo, e só libera os
 * itens dentro do "passthrough"
 */
$app->add(new \Slim\Middleware\JwtAuthentication([
    "regexp" => "/(.*)/", //Regex para encontrar o Token nos Headers - Livre
    "header" => "X-Token", //O Header que vai conter o token
    "path" => "/", //Vamos cobrir toda a API a partir do /
    //"passthrough" => ["/auth"], //Vamos adicionar a exceção de cobertura a rota /auth
    "passthrough" => [$container->get('settings')['authRoute'], "/"], //Vamos adicionar a exceção de cobertura a rota /auth
    "realm" => "Protected", 
    "secret" => $_ENV['JWT_SECRET'], //Nosso secretkey criado 
    "relaxed" => ["localhost", "devserver"],
]));


$app->add(new \App\Middleware\TokenValidate($app->getContainer()));