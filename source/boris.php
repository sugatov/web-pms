<?php
$scope['sl'] = require __DIR__ . '/lib/bootstrap.php';
$scope['reconnect'] = function () use ($scope) {
    $scope['sl']['entityManager']->getConnection()->close();
    return $scope['sl']['entityManager']->getConnection()->connect();
};

if (!function_exists('pcntl_signal')) {
    die("PCNTL support seems to be missing or disabled. See https://github.com/d11wtq/boris/issues/29 for details\n");
}

$boris = new \Boris\Boris();

$config = new \Boris\Config();
$config->apply($boris);

$options = new \Boris\CLIOptionsHandler();
$options->handle($boris);

$boris->setLocal($scope);
$boris->start();
