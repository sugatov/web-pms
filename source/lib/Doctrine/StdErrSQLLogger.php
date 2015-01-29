<?php
namespace Doctrine;

use Doctrine\DBAL\Logging\SQLLogger;

class StdErrSQLLogger implements SQLLogger
{
    public function startQuery($sql, array $params = null, array $types = null)
    {
        error_log("\r\n$sql");
        error_log(' with ' . var_export($params, true));
    }
 
    public function stopQuery()
    {
    }
}
