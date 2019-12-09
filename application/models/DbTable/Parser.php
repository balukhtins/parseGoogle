<?php

class Application_Model_DbTable_Parser extends Zend_Db_Table_Abstract
{
    protected $_name = 'parser';

    public function setParser($post)
    {
        $this->insert($post);
    }

    public function getPaginatorRows ($pageNumber, $itemCountPerPage, $desc)
    {
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($this->select()->order(array('id '.$desc))));
        $paginator->setCurrentPageNumber($pageNumber);
        $paginator->setItemCountPerPage($itemCountPerPage);
        $paginator->setPageRange(1);
        return $paginator;
    }
}

