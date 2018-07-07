<?php

/**
 * @author bloep
 */
class rex_api_clockwork extends rex_api_function {

    protected $published = true;
    public function execute()
    {
        $debug = rex_debug::getInstance();
        $storage = new Clockwork\Storage\FileStorage(rex_addon::get('debug')->getCachePath());
        $debug->setStorage($storage);

        /** @var \Clockwork\Storage\FileStorage $storage */
        $storage = $debug->getStorage();

        $id = rex_request::get('id');

        $split = explode('/', $id);

        $output = '[]';

        /** @var \Clockwork\Request\Request $request */
        if($id === 'latest') {
            $request = $storage->latest();
        } elseif($split[1] === 'next') {
            $request = $storage->next($split[0]);
        } elseif($split[1] === 'previous') {
            $request = $storage->previous($split[0], isset($split[2]) ? $split[2] : null);
        } else {
            $request = $storage->find($id);
        }

        if($request && is_array($request)) {
            $output = json_encode($request);
        } elseif($request && !is_array($request)) {
            $output = $request->toJson();
        }
        rex_response::sendContentType('application/json');
        rex_response::sendContent($output, 'application/json');
    }

    protected function requiresCsrfProtection()
    {
        return false;
    }

    public static function getUrlParams()
    {
        return [
            self::REQ_CALL_PARAM => 'clockwork',
            'id' => ''
        ];
    }
}