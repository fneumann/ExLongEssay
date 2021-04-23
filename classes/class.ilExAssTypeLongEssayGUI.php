<?php

require_once (__DIR__ . '/models/class.ilExLongEssayAssignment.php');
require_once (__DIR__ . '/traits/trait.ilExLongEssayGUIBase.php');

/**
 * Long Essay Assignment Type GUI
 * @ilCtrl_isCalledBy ilExAssTypeLongEssayGUI: ilExAssignmentEditorGUI
 */
class ilExAssTypeLongEssayGUI implements ilExAssignmentTypeGUIInterface
{
    use ilExAssignmentTypeGUIBase;
    use ilExLongEssayGUIBase;

    /** @var ilExLongEssayPlugin */
    protected $plugin;

    /**
     * Constructor
     *
     * @param ilExLongEssayPlugin
     */
    public function __construct($plugin)
    {
        $this->initGlobals();
        $this->plugin = $plugin;
    }

    /**
     * Execute command
     */
    public function executeCommand()
    {
        $next_class = $this->ctrl->getNextClass($this);
        $cmd = $this->ctrl->getCmd();

        switch ($next_class) {
            case 'ilexlongessaysettingsgui':
                require_once(__DIR__ . '/class.ilExLongEssaySettingsGUI.php');
                $gui = new ilExLongEssaySettingsGUI($this->plugin, $this->assignment);
                $this->tabs->activateTab('exlongesssay_settings');
                $this->ctrl->forwardCommand($gui);
                break;

            default:
                switch ($cmd) {
                    default:
                        if (in_array($cmd, [])) {
                           $this->$cmd();
                        }
                }
        }
    }


    /**
     * @inheritdoc
     */
    public function addEditFormCustomProperties(ilPropertyFormGUI $form)
    {
        if (isset($this->assignment)) {
            $assLong = ilExLongEssayAssignment::findOrGetInstance($this->assignment->getId());

            $uuid = new ilNonEditableValueGUI($this->plugin->txt('assignment_uuid'));
            $uuid->setInfo($this->plugin->txt('assignment_uuid_info'));
            $uuid->setValue($assLong->getUuid());
            $form->addItem($uuid);
        }
    }


    /**
     * Get values from form and put them into assignment
     * @param ilExAssignment $ass
     * @param ilPropertyFormGUI $form
     */
    public function importFormToAssignment(ilExAssignment $ass, ilPropertyFormGUI $form)
    {
        $assLong = ilExLongEssayAssignment::findOrGetInstance($ass->getId());
        if (empty($assLong->getUuid())) {
            $f = new \ILIAS\Data\UUID\Factory();
            $assLong->setUuid($f->uuid4AsString());
            $assLong->save();
        }
    }


    /**
     * Get form values array from assignment
     * @param ilExAssignment $ass
     * @return array
     */
    public function getFormValuesArray(ilExAssignment $ass)
    {
        return [];
    }

    /**
     * Add overview content of submission to info screen object
     * @param ilInfoScreenGUI $a_info
     * @param ilExSubmission $a_submission
     */
    public function getOverviewContent(ilInfoScreenGUI $a_info, ilExSubmission $a_submission)
    {
    }


    /**
     * @inheritdoc
     */
    public function handleEditorTabs(ilTabsGUI $tabs)
    {
        $tabs->removeTab('ass_files');

        $tabs->addTab('exlongesssay_settings',
            $this->plugin->txt('exlongessay_settings'),
            $this->ctrl->getLinkTargetByClass(['ilexassignmenteditorgui', strtolower(get_class($this)),'ilexlongessaysettingsgui']));
    }

}
