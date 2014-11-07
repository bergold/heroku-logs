<?php
require_once 'lib/storage.php';

$sh = Storage::fromDefaultBucket();

$sh->fileAppend('logs/iniii.log', '\nApphend');
