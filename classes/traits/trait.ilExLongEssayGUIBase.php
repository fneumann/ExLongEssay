<?php

trait ilExLongEssayGUIBase
{
    /** @var  ilAccessHandler $access */
    protected $access;

    /** @var ilCtrl $ctrl */
    protected $ctrl;

    /** @var  ilLanguage $lng */
    protected $lng;

    /** @var ilTabsGUI */
    protected $tabs;

    /** @var  ilToolbarGUI $toolbar */
    protected $toolbar;

    /** @var ilGlobalTemplateInterface */
    protected $tpl;


    protected function initGlobals()
    {
        global $DIC;
        $this->access = $DIC->access();
        $this->ctrl = $DIC->ctrl();
        $this->lng = $DIC->language();
        $this->tabs = $DIC->tabs();
        $this->toolbar = $DIC->toolbar();
        $this->tpl = $DIC['tpl'];
    }
}