<?php
$SL = require __DIR__ . '/../source/lib/bootstrap.php';
$SL['config'] = new \YamlSource($SL['LOCAL_APPS'] . '/manager.yml', $SL['PATHS']);
$SL['app']->run();
