<?php
require_once 'lib/storage.php';

$sh = Storage::fromDefaultBucket();

$sh->fileWrite('logs/iniii.log', 'hejehe');
