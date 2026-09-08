<?php

require_once __DIR__ . '/../vendor/autoload.php';

$capsule = require_once __DIR__ . '/../config/database.php';

$files = glob(__DIR__ . '/migrations/*.php');

sort($files);

foreach ($files as $file) {
    $migration = require $file;
    $migration($capsule);

    echo basename($file) . " exécutée avec succès." . PHP_EOL;
}