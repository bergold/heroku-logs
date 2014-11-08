<?php
require_once 'lib/storage.php';

header('Content-Type: text/plain');

$sh = Storage::fromDefaultBucket('/logs/');

$sh->fileAppend('test.log', "I want to append this\n");
