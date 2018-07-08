<?php
/**
 * @author bloep
 * @package redaxo/debug
 */
class rex_debug extends \Clockwork\Clockwork {
    use rex_singleton_trait;

    private $rexDataSource;

    public function __construct()
    {
        parent::__construct();
        $this->addDataSource(new Clockwork\DataSource\PhpDataSource());

        $this->rexDataSource = new RedaxoDataSource();

        $this->addDataSource($this->rexDataSource);
        $storage = new Clockwork\Storage\FileStorage(rex_addon::get('debug')->getCachePath());
        $this->setStorage($storage);
    }

    public function logEvent($eventName, $data, $file, $line) {
        $this->rexDataSource->logEvent($eventName, $data, $file, $line);
    }
}