<?php
require_once 'lib/storage.php';

$sh = Storage::fromDefaultBucket();

unlink($sh->buildPath('logs/iniii.log'));
