<?php
$SL = require __DIR__ . '/../source/lib/bootstrap.php';
// $SL['config'] = new \YamlSource($SL['LOCAL_APPS'] . '/manager.yml', $SL['PATHS']);

$config = array();
if ( ! $SL['cache']->exists('manager.yml')) {
    $config = new \YamlSource($SL['LOCAL_APPS'] . '/manager.yml', $SL['PATHS']);    
    $SL['cache']->set('manager.yml', serialize($config), 60);
} else {
    $config = unserialize($SL['cache']->get('manager.yml'));
}
$SL['config'] = $config;

function render($SL, $template, $scope, $status=null){
    $scope = array_merge_recursive($SL['globalViewScope'], $scope);
    if (isset($scope['errors'])) {
        $scope['errors'] = array_merge_recursive($scope['errors'], array());
    } else {
        $scope['errors'] = array();
    }
    foreach ($scope['errors'] as &$error) {
        if ($error['message'] instanceof \Exception) {
            $error['message'] = $error['message']->getMessage();
            $error['code']    = $error['message']->getCode();
        }
        unset($error);
    }
    $SL['app']->contentType('text/html;charset=utf-8');
    $SL['app']->render($template, $scope, $status);
}

$title   = 'Помощь';
$content = null;
if ( ! $SL['cache']->exists('help.index', 86400)) {
    $content = $SL['storage']->read('help.index');
    $content = $SL['markdownParser']->parse($content);
    $SL['cache']->set('help.index', $content);
} else {
    $content = $SL['cache']->get('help.index');
}
render($SL, 'Help/index.twig', array('title'=>$title, 'content'=>$content));
