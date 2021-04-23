<?php

/**
 * Plugin Configuration
 */
class ilExLongEssayConfig
{
    protected $settings;


    public function __construct()
    {
        $this->settings = new ilSetting('exlongessay', true);

        // todo: fill config properties with the settings
    }


    public function write()
    {
        // todo: write config properties to the settings
    }
}