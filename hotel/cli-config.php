<?php
$ServiceLocator = require dirname(__FILE__) . '/lib/bootstrap.php';

// Doctrine ORM <= 2.3:
/*
$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($ServiceLocator['entityManager']->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($ServiceLocator['entityManager'])
));
*/

// Doctrine ORM >= 2.4:
return Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($ServiceLocator['entityManager']);
