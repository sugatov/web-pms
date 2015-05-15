<?php
$SL = require __DIR__ . '/../source/lib/bootstrap.php';

$config = array();
if ( ! $SL['cache']->exists('manager.yml')) {
    $config = new \YamlSource($SL['LOCAL_APPS'] . '/manager.yml', $SL['PATHS']);
    $maxAge = 43200;
    if ($config['app']['debug']) {
        $maxAge = 10;
    }
    $SL['cache']->set('manager.yml', serialize($config), $maxAge);
} else {
    $config = unserialize($SL['cache']->get('manager.yml'));
}
$SL['config'] = $config;

$SL['app']->run();
