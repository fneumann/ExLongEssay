<?php

require_once ('./Modules/Exercise/classes/class.ilAssignmentHookPlugin.php');

/**
 * Plugin for Long Essay exercise Assignments
 */
class ilExLongEssayPlugin extends ilAssignmentHookPlugin
{
    /** @var ilExLongEssayConfig */
    protected $config;

    /** @var self */
    protected static $instance;


    /**
     * Get Plugin Name. Must be same as in class name il<Name>Plugin
     * and must correspond to plugins subdirectory name.
     * @return    string    Plugin Name
     */
    function getPluginName() {
        return "ExLongEssay";
    }

    /**
     * Uninstall custom data of this plugin
     */
    protected function uninstallCustom()
    {
        global $DIC;
        $db = $DIC->database();

        $db->dropTable('exlongessay_assignment', false);
    }

    /**
     * Get the plugin instance
     * @return ilExLongEssayPlugin
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    /**
     * Get the plugin configuration
     * @return ilExLongEssayConfig
     */
    public function getConfig()
    {
        if (!isset($this->config))
        {
            require_once (__DIR__ . '/models/class.ilExLongEssayConfig.php');
            $this->config = new ilExLongEssayConfig();
        }
        return $this->config;
    }

    /**
     * Get the ids of the available assignment types
     */
    public function getAssignmentTypeIds() {
        return [50];
    }


    /**
     * Get an assignment type by its id
     * @param integer $a_id
     * @return ilExAssignmentTypeInterface
     */
    public function getAssignmentTypeById($a_id) {
        switch ((int) $a_id) {
            case 50:
                require_once(__DIR__ . '/class.ilExAssTypeLongEssay.php');
                return new ilExAssTypeLongEssay($this);
        }
    }

    /**
     * Get an assignment type GUI by its id
     * @param integer $a_id
     * @return ilExAssignmentTypeGUIInterface
     */
    public function getAssignmentTypeGUIById($a_id) {
        switch ((int) $a_id) {
            case 50:
                require_once(__DIR__ . '/class.ilExAssTypeLongEssayGUI.php');
                return new ilExAssTypeLongEssayGUI($this);
        }
    }

    /**
     * Get the string identifiers of the available assignment types
     * plugin authors have to take care of unique string identifiers
     * @return string[]
     */
    function getAssignmentTypeStringIdentifiers()
    {
        return ['long_essay'];
    }

    /**
     * Get an assignment type by its string identifier
     * @param string $a_identifier
     * @return ilExAssignmentTypeInterface
     */
    function getAssignmentTypeByStringIdentifier(string $a_identifier)
    {
        if ($a_identifier == 'long_essay') {
            return new ilExAssTypeLongEssay($this);
        }
        return new ilExAssTypeInactive();
    }

    /**
     * Get an assignment type GUI by its string identifier
     * @param string $a_identifier
     * @return ilExAssignmentTypeGUIInterface
     */
    function getAssignmentTypeGUIByStringIdentifier(string $a_identifier)
    {
        if ($a_identifier == 'long_essay') {
            return new ilExAssTypeLongEssayGUI($this);
        }
        return new ilExAssTypeLongEssayGUI($this);
    }

    /**
     * Get the class names of the assignment type GUIs
     * @return string[] (indexed by string identifier)
     */
    public function getAssignmentTypeGuiClassNames() {
        return [
            'long_essay' => 'ilExAssTypeLongEssayGUI',
        ];
    }


}