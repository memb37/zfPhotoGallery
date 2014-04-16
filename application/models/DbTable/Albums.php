<?php

class Application_Model_DbTable_Albums extends Zend_Db_Table_Abstract
{

    protected $_name = 'albums';
    protected $_dependentTables = array('Application_Model_DbTable_Photos');

}

