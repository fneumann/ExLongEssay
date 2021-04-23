<?php

require_once (__DIR__ . '/models/class.ilExLongEssayAssignment.php');
require_once (__DIR__ . '/traits/trait.ilExLongEssayGUIBase.php');


/**
 * Specific settings of a long essay assignment
 *
 * @ilCtrl_isCalledBy ilExLongEssaySettingsGUI: ilExAssTypeLongEssayGUI
 */
class ilExLongEssaySettingsGUI
{
    use ilExLongEssayGUIBase;

    /** @var ilExLongEssayPlugin */
    protected $plugin;

    /** @var ilExAssignment */
    protected $assignment;

    /**
     * Constructor
     *
     * @param ilExLongEssayPlugin
     * @param ilExAssignment $assignment
     */
    public function __construct(ilExLongEssayPlugin $plugin, ilExAssignment $assignment)
    {
        $this->initGlobals();
        $this->plugin = $plugin;
        $this->assignment = $assignment;
    }

    /**
     * Execute command
     */
    public function executeCommand()
    {
        $next_class = $this->ctrl->getNextClass($this);
        $cmd = $this->ctrl->getCmd('showSettings');

        switch ($next_class) {

            default:
                switch ($cmd) {
                    case 'showSettings':
                    case 'saveSettings':
                        $this->$cmd();
                        break;
                    default:
                        $this->tpl->setContent($cmd);
                }
        }
    }

    /**
     * Show the settings
     */
    public function showSettings()
    {
        $form = $this->initSettingsForm();
        $this->tpl->setContent($form->getHTML());
    }


    /**
     * Save the settings
     */
    public function saveSettings()
    {
        $form = $this->initSettingsForm();
        $form->setValuesByPost();
        if ($form->checkInput()) {
            $assLong = ilExLongEssayAssignment::findOrGetInstance($this->assignment->getId());
            $assLong->setManageCorrectors($form->getInput('manage_correctors'));
            $assLong->save();

            ilUtil::sendSuccess($this->lng->txt('settings_saved'), true);
            $this->ctrl->redirect($this, 'showSettings');
        }
        else {
            $form->setValuesByPost();
            $this->tpl->setContent($form->getHTML());
        }
   }


    /**
     * @return ilPropertyFormGUI
     */
    public function initSettingsForm()
    {
        $assLong = ilExLongEssayAssignment::findOrGetInstance($this->assignment->getId());

        $form = new ilPropertyFormGUI();
        $form->setFormAction($this->ctrl->getFormAction($this));
        $form->setTitle($this->plugin->txt('exlongessay_settings'));
        $form->addCommandButton('saveSettings', $this->lng->txt('save_settings'));

        $manageCorrectors = new ilCheckboxInputGUI($this->plugin->txt('manage_correctors'), 'manage_correctors');
        $manageCorrectors->setInfo($this->plugin->txt('manage_correctors_info'));
        $manageCorrectors->setChecked($assLong->getManageCorrectors());
        $form->addItem($manageCorrectors);

        return $form;
    }

}
