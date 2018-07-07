<?php
/**
 * @author bloep
 * @package redaxo/debug
 *
 * @var rex_addon $this
 */
$basePath = $this->getPath('vendor/itsgoingd/clockwork/Clockwork/Web/public/assets');
$files = rex_finder::factory($basePath)
    ->recursive()
    ->filesOnly()
    ->getIterator();

/** @var SplFileInfo $file */
foreach ($files as $file ) {
    $source = $file->getRealPath();
    $destination = str_replace($basePath, '', $source);
    rex_file::copy($source, $this->getAssetsPath($destination));
}