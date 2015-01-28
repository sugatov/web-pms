<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);

$ServiceLocator = require __DIR__ . '/../../hotel/lib/bootstrap.php';

$ServiceLocator['config'] = new \YamlSource(__DIR__ . '/../../hotel/apps/mng.yml', $ServiceLocator['PATHS']);

$acl = $ServiceLocator['acl'];

if ($acl->isAllowed('customer', 'room', 'view')) {
    echo "Customer is allowed to view room \r\n";
}
if (! $acl->isAllowed('customer', 'service', 'provide')) {
    echo "Customer cannot provide a service! \r\n";
}
if ($acl->isAllowed('operator', 'service', 'provide')) {
    echo "Operator can provide a service. \r\n";
}
if ($acl->isAllowed('superuser', 'service', 'provide')) {
    echo "Superuser can provide a service \r\n";
}
if ( ! $acl->isAllowed('operator', 'report', 'view')) {
    echo "Operator cannot view a report \r\n";
}
if ($acl->isAllowed('manager', 'service', 'modify')) {
    echo "Manager can modify a service \r\n";
}
if ($acl->isAllowed('superuser', 'user', 'modify')) {
    echo "Superuser can modify a user \r\n";
}

print_r($ServiceLocator['config']);
