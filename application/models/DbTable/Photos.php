<?php

class Application_Model_DbTable_Photos extends Zend_Db_Table_Abstract
{

    protected $_name = 'photos';
    protected $_referenceMap = array(
        'Album' => array(
            'columns' => 'album_id',
            'refTableClass' => 'Application_Model_DbTable_Albums',
            'refColumns' => 'id'
        )
    );

}

