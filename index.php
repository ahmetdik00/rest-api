<?php

declare(strict_types=1);

spl_autoload_register(function($class){
    require __DIR__ . "/src/$class.php";
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$uri = explode('/', $_SERVER["REQUEST_URI"]); //REQUEST_METHOD bunu da uygula

if($uri[1] != "products") {
    http_response_code(404);
    exit;
}

$id = $uri[2] ?? null;

$database = new Database("localhost", "api", "root", "");

$gateway =  new ProductGateway($database);

$controller = new ProductController($gateway);

$controller->productRequest($_SERVER["REQUEST_METHOD"], $id);