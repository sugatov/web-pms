<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);

$ServiceLocator = require __DIR__ . '/../../hotel/lib/bootstrap.php';

$ServiceLocator['config'] = new \YamlSource(__DIR__ . '/../../hotel/apps/mng.yml', $ServiceLocator['PATHS']);

$ServiceLocator['app']->run();
