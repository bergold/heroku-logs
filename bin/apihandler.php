<?php
require_once 'lib/util.php';
require_once 'lib/router.php';
require_once 'lib/storage.php';
require_once 'lib/logger.php';

$router = new Router(path("/api"));

$router->when("/apps", function () {
    echo "Apps";
});

$router->when("/:appname/logs", function ($params) {
    $storage_handle = Storage::fromDefaultBucket("/logs/");
    Logger::setStorageInstance($storage_handle);

    $logger = Logger::get($params['appname']);
    if ($logger === false) {
        echo "logger not found";
        http_response_code(404);
        exit(1);
    }
    
    header("Content-Type: text/plain");
    echo $logger->fetch(null);
});

$router->when("/:appname/drains", function ($params) {
    echo "Drains: ";
    var_dump($params);
});

$router->otherwise(function () {
    http_response_code(400);
});
