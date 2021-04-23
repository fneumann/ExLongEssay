<#1>
<?php
    /**
     * ExLongEssay Plugin: database update script
     *
     * @author Fred Neumann <neumann@ilias.de>
     */

    global $DIC;
    $ilDB = $DIC->database();

?>
<#2>
<?php
    $fields = array(
        'id' => array(
            'notnull' => '1',
            'type' => 'integer',
            'length' => '4',
        ),
        'exercise_id' => array(
            'notnull' => '1',
            'type' => 'integer',
            'length' => '4',
        ),
        'uuid' => array(
            'type' => 'text',
            'length' => '50',
        ),
        'manage_correctors' => array(
            'type' => 'integer',
            'length' => '4',
        ),
    );
    if (! $ilDB->tableExists('exlongessay_assignment')) {
        $ilDB->createTable('exlongessay_assignment', $fields);
        $ilDB->addPrimaryKey('exlongessay_assignment', array( 'id' ));

        if (! $ilDB->sequenceExists('exlongessay_assignment')) {
            $ilDB->createSequence('exlongessay_assignment');
        }
        $ilDB->addIndex('exlongessay_assignment', ['exercise_id'], 'i1');
        $ilDB->addIndex('exlongessay_assignment', ['uuid'], 'i2');
    }

?>