<?php

/**
 * @package redaxo\debug
 */
abstract class rex_api_function_debug extends rex_api_function
{
    public static function handleCall()
    {
        $apiFunc = self::factory();

        if ($apiFunc != null) {
            $debug = rex_debug::getInstance();
            $debug->debug('Called api function '.get_class($apiFunc));
        }
        return parent::handleCall();
    }
}
