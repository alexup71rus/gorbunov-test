<?php
namespace Includes;

class Settings
{
    private $settings = [];
    private static $instance = null;
    //public $test;
    private function __construct()
    {
        $settingsFilePath = __DIR__ . '/../settings.php';
        $settingsFile = include_once(realpath($settingsFilePath));
        if (!$settingsFile && !is_array($settingsFile))
            throw new \Exception('Проблемы с определением настроек системы');
        else
            $this->settings = $settingsFile;
    }
    protected function __clone()
    {
    }
    static function getInstance()
    {
        if (is_null(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function __call($name, $arg = [])
    {
        if (array_key_exists($name, $this->settings))
        {
            return $this->settings[$name];
        }
        else
        {
            //@todo: возможно нужно будет бросать исключение в данном случае
        }
    }
}