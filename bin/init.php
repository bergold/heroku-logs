<?php
require_once 'lib/storage.php';

header("Content-Type: test/plain");

$sh = Storage::fromDefaultBucket();

stry("create logs dir", mkdir($sh->buildPath('logs/')));

function stry($msg, $res) {
    echo $msg;
    echo $res ? " succeeded" : " failed";
    echo "\n";
}
