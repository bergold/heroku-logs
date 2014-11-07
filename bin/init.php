<?php
require_once 'lib/storage.php';

$sh = Storage::fromDefaultBucket();

$options = [
  'gs' => [
        'Content-Type' => 'text/plain'
  ],
];
$ctx = stream_context_create($options);
file_put_contents($sh->buildPath('logs/ricochetrobots.log'), '', 0, $ctx);

function stry($msg, $res) {
    echo $msg;
    echo $res ? " succeeded" : " failed";
    echo "\n";
}
