<?php
/**
 * @var $this rex_addon
 */

$clockwork = rex_debug::getInstance();

rex_sql::setFactoryClass('rex_sql_debug');
rex_extension::setFactoryClass('rex_extension_debug');
rex_logger::setFactoryClass('rex_logger_debug');
rex_api_function::setFactoryClass('rex_api_function_debug');

rex_extension::register('OUTPUT_FILTER', function() {
    //TODO @bloep AUF debug seite beschränken
    $clockwork = rex_debug::getInstance();
    rex_response::setHeader('X-Clockwork-Id', $clockwork->getRequest()->id);
    rex_response::setHeader('X-Clockwork-Version', rex_debug::VERSION);
    rex_response::setHeader('X-Clockwork-Path', rex_url::backendController(rex_api_clockwork::getUrlParams(), false));
});

rex_extension::register('RESPONSE_SHUTDOWN', function(rex_extension_point $ep) {
    $clockwork = rex_debug::getInstance();
    $clockwork->resolveRequest()->storeRequest();
}, rex_extension::LATE);