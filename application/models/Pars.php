<?php

class Application_Model_Parser
{
    protected $_id;
    protected $_domain;
    protected $_word;
    protected $_position;
    protected $_date;

    public function __set($name, $value);
    public function __get($name);

    public function setDomain($text);
    public function getDomain();

    public function setWord($email);
    public function getWord();

    public function setPosition($ts);
    public function getPosition();

    public function setId();

    public function setDate();
}

class Application_Model_ParserShow
{
    public function save(Application_Model_Parser $parser);
    public function find($id);
    public function fetchAll();
}
