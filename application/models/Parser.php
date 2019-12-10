<?php

class Application_Model_Parser
{
    protected $_id;
    protected $_domain;
    protected $_word;
    protected $_position;
    protected $_date;

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid parser property');
        }
        $this->$method($value);
    }
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid parser property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function setDomain($domain)
    {
        $this->_domain = (string) $domain;
        return $this;
    }

    public function getDomain()
    {
        return $this->_domain;
    }

    public function setWord($word)
    {
        $this->_word = (string) $word;
        return $this;
    }
    public function getWord()
    {
        return $this->_word;
    }

    public function setPosition($position)
    {
        $this->_position = (string) $position;
        return $this;
    }
    public function getPosition()
    {
        return $this->_position;
    }

    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getDate()
    {
        return $this->_date;
    }
}
