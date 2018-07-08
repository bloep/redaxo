<?php
/**
 * @author bloep
 */

use Clockwork\DataSource\DataSource;
use Clockwork\Request\Request;

class RedaxoDataSource extends DataSource
{
    private $events = [];

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request)
    {
        $request->databaseQueries = rex_sql_debug::getDebugData();
        $request->events = $this->getEvents();

        return $request;
    }

    private function getEvents()
    {
        return $this->events;
    }

    public function logEvent($eventName, $data, $file, $line)
    {
        $coreTimer = rex::getProperty('timer');
        $this->events[] = [
            'event'=> $eventName,
            'data' => \Clockwork\Helpers\Serializer::simplify(count($data) == 1 && isset($data[0]) ? $data[0] : $data),
            'time' => $coreTimer->getDelta(),
            'file'=> $file,
            'line' => $line
        ];
    }
}