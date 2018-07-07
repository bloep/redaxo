<?php
/**
 * @author bloep
 * @package redaxo/debug
 */

/**
 * @var rex_addon $this
 */
rex_response::cleanOutputBuffers();
$html = rex_file::get($this->getPath('vendor/itsgoingd/clockwork/Clockwork/Web/public/app.html'));

$html = preg_replace('/assets\/([^"]+)/', $this->getAssetsUrl('$1'), $html);


echo $html;


die();