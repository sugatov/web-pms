<?php
namespace Doctrine;

use Doctrine\DBAL\Logging\SQLLogger;
use Timer;

class StdErrSQLLogger implements SQLLogger
{
    /**
     * @var Timer
     */
    protected $timer;

    public function startQuery($sql, array $params = null, array $types = null)
    {
        $this->timer = new Timer();
        error_log("\033[0;1;36m$sql");
        foreach ($params as $index=>$param) {
            error_log("\033[0;33m($types[$index]) \033[1m$param\033[0m");
        }
    }

    public function stopQuery()
    {
        error_log("\033[0mQuery time: \033[1m".$this->timer->stop()."\033[0m" . PHP_EOL);
    }
}
