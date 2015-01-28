<?php
$SL = require __DIR__ . '/lib/bootstrap.php';
$EM = $SL['entityManager'];

$env = array();

$env['SL']              = $SL;
$env['EM']              = $EM;

$env['rBooking']        = $EM->getRepository('Entities\Booking');
$env['sUsers']          = $SL['users'];

$env['sSerializer']     = $SL['serializer'];


function emreconnect()
{
    $SL = ServiceLocator::getInstance();
    return $SL['reconnectToDB']();
}

function empersist($entity)
{
    return ServiceLocator::getInstance()
           ->offsetGet('entityManager')
           ->persist($entity);
}

function emmerge($entity)
{
    return ServiceLocator::getInstance()
           ->offsetGet('entityManager')
           ->merge($entity);
}

function emremove($entity)
{
    return ServiceLocator::getInstance()
           ->offsetGet('entityManager')
           ->remove($entity);
}

function emflush()
{
    return ServiceLocator::getInstance()
           ->offsetGet('entityManager')
           ->flush();
}

function osserialize($obj)
{
    return ServiceLocator::getInstance()
           ->offsetGet('serializer')
           ->serialize($obj);
}


$boris = new \Boris\Boris();
$boris->setLocal($env);
$boris->start();
