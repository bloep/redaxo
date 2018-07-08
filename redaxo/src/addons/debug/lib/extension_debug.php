<?php

/**
 * Class to monitor extension points via ChromePhp.
 *
 * @author staabm
 *
 * @package redaxo\debug
 */
class rex_extension_debug extends rex_extension
{
    public static function register($extensionPoint, callable $extension, $level = self::NORMAL, array $params = [])
    {
        $debug = rex_debug::getInstance();
        parent::register($extensionPoint, $extension, $level, $params);

        $trace = self::getTrace();
        $debug->logEvent('Register extension point: '.$extensionPoint, $params, $trace[0], $trace[1]);

        $debug->debug('Register extension point: '.$extensionPoint,[
            'ep' => $extensionPoint,
            'callable' => $extension,
            'level' => $level,
            'params' => $params,
        ]);
    }

    public static function registerPoint(rex_extension_point $extensionPoint)
    {
        $debug = rex_debug::getInstance();
        $debug->startEvent('call_'.$extensionPoint->getName(), 'EP Call: '.$extensionPoint->getName());
        $res = parent::registerPoint($extensionPoint);
        $debug->endEvent('call_'.$extensionPoint->getName());

        $memory = rex_formatter::bytes(memory_get_usage(true), [3]);

        $debug->debug('RUN EP '.$extensionPoint->getName(), [
            'subject' => $extensionPoint->getSubject(),
            'params'=> $extensionPoint->getParams(),
            'read_only' => $extensionPoint->isReadonly(),
            'memory' => $memory,
            'result'=> $res
        ]);

        return $res;
    }

    private static function getTrace() {
        $trace = debug_backtrace();
        $file = null;
        $line = null;
        for ($i = 0; $trace && $i < count($trace); ++$i) {
            if (isset($trace[$i]['file']) && strpos($trace[$i]['file'], 'extension.php') === false && strpos($trace[$i]['file'], 'extension_debug.php') === false&& strpos($trace[$i]['file'], 'factory_trait.php') === false) {
                $file = $trace[$i]['file'];
                $line = $trace[$i]['line'];
                break;
            }
        }
        return [$file, $line];
    }
}
