<?php

/**
 * Specific properties of a long Essay Assignments
 */
class ilExLongEssayAssignment extends ActiveRecord
{
    /**
     * @var string
     */
    protected $connector_container_name = 'exlongessay_assignment';


    /**
     * @var int
     * @con_is_primary true
     * @con_is_unique  true
     * @con_has_field  true
     * @con_fieldtype  integer
     * @con_is_notnull true
     * @con_length     4
     */
    protected $id = 0;

    /**
     * @var int
     * @con_has_field  true
     * @con_fieldtype  integer
     * @con_length     4
     * @con_is_notnull true
     */
    protected $exercise_id = 0;


    /**
     * @var string
     *
     * @con_has_field true
     * @con_fieldtype text
     * @con_length    50
     * @con_is_notnull false
     */
    protected $uuid = '';


    /**
     * @var string
     *
     * @con_has_field true
     * @con_fieldtype integer
     * @con_length    4
     * @con_is_notnull false
     */
    protected $manage_correctors = 0;

    /**
     * Wrapper to declare the return type
     * @param  mixed $primary_key
     * @param array $add_constructor_args
     * @return self
     */
    public static function findOrGetInstance($primary_key, array $add_constructor_args = array())
    {
        /** @var self $record */
        $record =  parent::findOrGetInstance($primary_key, $add_constructor_args);
        return $record;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;

        // reset the exercise id to force a lookup when record is stored
        $this->exercise_id = 0;
    }

    /**
     * @return int
     */
    public function getExerciseId() : int
    {
        return $this->exercise_id;
    }

    /**
     * @param int $exercise_id
     */
    public function setExerciseId(int $exercise_id)
    {
        $this->exercise_id = $exercise_id;
    }

    /**
     * @return string
     */
    public function getUuid() : string
    {
        return (string) $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return bool
     */
    public function getManageCorrectors(): bool
    {
        return (bool) $this->manage_correctors;
    }

    /**
     * @param bool $manage_correctors
     */
    public function setManageCorrectors(bool $manage_correctors)
    {
        $this->manage_correctors = (bool) $manage_correctors;
    }


    /**
     * Save the record
     * ensure the matching exercise id being saved
     */
    public function store() {
        if (empty($this->getExerciseId())) {
            $ass = new ilExAssignment($this->getId());
            $this->setExerciseId($ass->getExerciseId());
        }
        parent::store();
    }

}