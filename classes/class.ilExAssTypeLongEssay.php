<?php
/**
 * Definition of the long Essay Assignment Type
 */
class ilExAssTypeLongEssay implements ilExAssignmentTypeInterface
{
    /** @var ilExLongEssayPlugin */
    protected $plugin;

    /**
     * Constructor
     *
     * @param ilExLongEssayPlugin
     */
    public function __construct($plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @inheritdoc
     */
    public function isActive()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function usesTeams() {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function usesFileUpload()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function getTitle() {
        return $this->plugin->txt('type_long_essay');
    }

    /**
     * @inheritdoc
     */
    public function getSubmissionType()
    {
        return ilExSubmission::TYPE_TEXT;
    }

    /**
     * @inheritdoc
     */
    public function isSubmissionAssignedToTeam() {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function cloneSpecificProperties(ilExAssignment $source, ilExAssignment $target)
    {
        require_once (__DIR__ . '/models/class.ilExLongEssayAssignment.php');

        $longSource = ilExLongEssayAssignment::findOrGetInstance($source->getId());
        $longTarget = clone $longSource;
        $longTarget->setId($target->getId());
        $longTarget->setExerciseId($target->getExerciseId());
        $longTarget->setUuid((new \ILIAS\Data\UUID\Factory())->uuid4AsString());
        $longTarget->save();
    }

    /**
     * @inheritdoc
     */
    public function deleteSpecificProperties(ilExAssignment $assignment)
    {
        $long = ilExLongEssayAssignment::findOrGetInstance($assignment->getId());
        $long->delete();
    }


    /**
     * @inheritdoc
     */
    public function supportsWebDirAccess(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function getStringIdentifier(): string
    {
        return 'long_essay';
    }
}
