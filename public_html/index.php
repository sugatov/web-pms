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

if ($SL['config']['app']['debug']) {
    $timer = $SL['timer'];
    error_log("Application start" . PHP_EOL);
    $SL['app']->run();
    error_log("\033[1;41;37mExecution time: ".$timer->stop()."\033[0m" . PHP_EOL);

} else {
    $SL['app']->run();
}

