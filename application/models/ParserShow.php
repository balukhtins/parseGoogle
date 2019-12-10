<?php

class Application_Model_ParserShow
{
    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Parser');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Parser $parser)
    {
        $data = array(
            'domain'   => $parser->getDomain(),
            'word' => $parser->getWord(),
            'position' => $parser->getPosition(),
        );

        $this->getDbTable()->insert($data);
    }

   /* public function find($id, Application_Model_Parser $parser)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $parser->setId($row->id)
            ->setDomain($row->domain)
            ->setWord($row->word)
            ->setPosition($row->position)
            ->setDate($row->date);
    }*/

    /*public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Parser();
            $entry->setId($row->id)
                ->setDomain($row->domain)
                ->setWord($row->word)
                ->setPosition($row->position)
                ->setDate($row->date);
            $entries[] = $entry;
        }
        return $entries;
    }*/

    public function getPaginatorRows ($pageNumber, $itemCountPerPage, $desc)
    {
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($this->getDbTable()->select()->order(array('id '.$desc))));
        $paginator->setCurrentPageNumber($pageNumber);
        $paginator->setItemCountPerPage($itemCountPerPage);
        $paginator->setPageRange(1);
        return $paginator;
    }
}

