<?php

/**
 * Class to monitor sql queries.
 *
 * @author staabm
 *
 * @package redaxo\debug
 */
class rex_sql_debug extends rex_sql
{
    private static $queries = [];

    /**
     * {@inheritdoc}.
     */
    public function setQuery($qry, array $params = [], array $options = [])
    {
        try {
            $timer = new rex_timer();
            parent::setQuery($qry, $params, $options);

            $trace = $this->getTrace();

            self::$queries[] = [
                'duration' => $timer->getDelta(),
                'query' => $qry,
                'connection' => $this->DBID,
                'file'=> $trace[0],
                'line' => $trace[1],
            ];

        } catch (rex_exception $e) {


            // LOL


            throw $e; // re-throw exception after logging
        }

        return $this;
    }

    /**
     * {@inheritdoc}.
     */
    public function execute(array $params = [], array $options = [])
    {
        $qry = $this->stmt->queryString;

        $timer = new rex_timer();
        parent::execute($params, $options);

        $trace = $this->getTrace();
        self::$queries[] = [
            'duration' => $timer->getDelta(),
            'query' => $qry,
            'connection' => $this->DBID,
            'file'=> $trace[0],
            'line' => $trace[1],
        ];

        return $this;
    }

    public static function getDebugData()
    {
        return self::$queries;
    }

    private function getTrace() {
        $trace = debug_backtrace();
        $file = null;
        $line = null;
        for ($i = 0; $trace && $i < count($trace); ++$i) {
            if (isset($trace[$i]['file']) && strpos($trace[$i]['file'], 'sql.php') === false && strpos($trace[$i]['file'], 'sql_debug.php') === false) {
                $file = $trace[$i]['file'];
                $line = $trace[$i]['line'];
                break;
            }
        }
        return [$file, $line];
    }
}
