<?php
/**
 * Plugin Configuration GUI
 *
 * @ilCtrl_Calls: ilExLongEssayConfigGUI: ilPropertyFormGUI
 */
class ilExLongEssayConfigGUI extends ilPluginConfigGUI
{
	/** @var ilExLongEssayPlugin $plugin */
	protected $plugin;

    /** @var ilExLongEssayConfig $config */
    protected $config;

	/** @var ilTabsGUI $tabs */
    protected $tabs;

    /** @var ilCtrl $ctrl */
    protected $ctrl;

    /** @var ilLanguage $lng */
	protected $lng;

    /** @var ilGlobalTemplateInterface */
	protected $tpl;

    /** @var  ilToolbarGUI $toolbar */
    protected $toolbar;

    /**
	 * Handles all commands, default is "configure"
     * @param string $cmd
     * @throws Exception
	 */
	public function performCommand($cmd)
	{
        global $DIC;

        // this can't be in constructor
        $this->plugin = $this->getPluginObject();
        $this->config = $this->plugin->getConfig();
        $this->lng = $DIC->language();
        $this->tabs = $DIC->tabs();
        $this->ctrl = $DIC->ctrl();
        $this->tpl = $DIC->ui()->mainTemplate();
        $this->toolbar = $DIC->toolbar();


        $this->tabs->addTab('basic', $this->plugin->txt('basic_configuration'), $this->ctrl->getLinkTarget($this, 'configure'));
        $this->setToolbar();

        switch ($DIC->ctrl()->getNextClass())
        {
            case 'ilpropertyformgui':
                switch ($_GET['config'])
                {
                    case 'basic':
                        $DIC->ctrl()->forwardCommand($this->initBasicConfigurationForm());
                        break;
                }

                break;

            default:
                switch ($cmd)
                {
                    case "configure":
                    case "saveBasicSettings":
                    case "updateLanguages":
                    case "generateDBUpdate":
                        $this->tabs->activateTab('basic');
                        $this->$cmd();
                        break;
                }
        }
	}

    /**
     * Set the toolbar
     */
    protected function setToolbar()
    {
        $this->toolbar->setFormAction($this->ctrl->getFormAction($this));

        $button = ilLinkButton::getInstance();
        $button->setUrl($this->ctrl->getLinkTarget($this, 'updateLanguages'));
        $button->setCaption($this->plugin->txt('update_languages'), false);
        $this->toolbar->addButtonInstance($button);

        $button = ilLinkButton::getInstance();
        $button->setUrl($this->ctrl->getLinkTarget($this, 'generateDBUpdate'));
        $button->setCaption($this->plugin->txt('generate_db_update'), false);
        $this->toolbar->addButtonInstance($button);
    }

    /**
	 * Show base configuration screen
	 */
	protected function configure()
	{
		$form = $this->initBasicConfigurationForm();
		$this->tpl->setContent($form->getHTML());
	}

    /**
     * Update Languages
     */
    protected function updateLanguages()
    {
        $this->plugin->updateLanguages();
        $this->ctrl->redirect($this, 'configure');
    }


    /**
     * Generate the db update steps for active record
     */
	protected function generateDBUpdate()
    {
        require_once (__DIR__ . '/models/class.ilExLongEssayAssignment.php');
        $arBuilder = new arBuilder(new ilExLongEssayAssignment());
        $arBuilder->generateDBUpdateForInstallation();
    }

    /**
	 * Initialize the configuration form
	 * @return ilPropertyFormGUI form object
	 */
	protected function initBasicConfigurationForm()
	{
		$form = new ilPropertyFormGUI();
        $form->setTitle($this->plugin->txt('basic_configuration'));
		$form->setFormAction($this->ctrl->getFormAction($this));

        // todo: add settings

		$form->addCommandButton("saveBasicSettings", $this->lng->txt("save"));
		return $form;
	}

	/**
	 * Save the basic settings
	 */
	protected function saveBasicSettings()
	{
		$form = $this->initBasicConfigurationForm();
		if ($form->checkInput())
		{
            // todo: handle settings

            $this->config->write();

			ilUtil::sendSuccess($this->lng->txt("settings_saved"), true);
			$this->ctrl->redirect($this, 'configure');
		}
		else
		{
			$form->setValuesByPost();
			$this->tpl->setContent($form->getHtml());
		}
	}
}