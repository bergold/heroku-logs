<?php
require_once 'lib/util.php';
require_once 'lib/router.php';
require_once 'lib/storage.php';
require_once 'lib/logger.php';

$router = new Router(path("/api"));

$router->get("/apps", function () {
    $storage_handle = Storage::fromDefaultBucket("/logs/");
    Logger::setStorageInstance($storage_handle);
    
    $loggers = Logger::get();
    $loggers = array_map(function($l) { return $l->getName(); }, $loggers);
    
    header("Content-Type: application/json");
    echo json_encode($loggers);
});

$router->post("/apps", function () {
    http_response_code(501);
});

$router->delete("/apps", function () {
    http_response_code(501);
});

$router->get("/:appname/logs", function ($params) {
    $storage_handle = Storage::fromDefaultBucket("/logs/");
    Logger::setStorageInstance($storage_handle);

    $logger = Logger::get($params['appname']);
    if ($logger === false) {
        http_response_code(404);
        exit(1);
    }
    
    header("Content-Type: text/plain");
    echo $logger->fetch(null);
});

$router->get("/:appname/drains", function ($params) {
    http_response_code(501);
});

$router->post("/:appname/drains", function ($params) {
    http_response_code(501);
});

$router->delete("/:appname/drains", function ($params) {
    http_response_code(501);
});

$router->get("/:appname/collaborators", function ($params) {
    http_response_code(501);
});

$router->post("/:appname/collaborators", function ($params) {
    http_response_code(501);
});

$router->delete("/:appname/collaborators", function ($params) {
    http_response_code(501);
});

$router->post("/:appname/rename", function($params) {
    http_response_code(501);
});

$router->otherwise(function () {
    http_response_code(400);
});
