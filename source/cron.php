<?php
$sl = require __DIR__ . '/lib/bootstrap.php';
$sl['setTimezone'];
$sl['statistics']->flushToDatabase();
$sl['statistics']->preparePopularToday();
$sl['statistics']->preparePopularThisWeek();
