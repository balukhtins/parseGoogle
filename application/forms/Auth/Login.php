<?php

class Application_Auth_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->setName('login');

        $this->setMethod('post')
            ->setAction('/parser/login')
            ->setAttrib('id', 'form_login');

        $this->addElement(
            'text', 'username', array(
            'label' => 'Username:',
            'required' => true,
            'filters'    => array('StringTrim','StripTags'),
            'validators' => array('NotEmpty'),
        ));

        $this->addElement('password', 'password', array(
            'label' => 'Password:',
            'required' => true,
            'filters'    => array('StringTrim','StripTags'),
            'validators' => array('NotEmpty'),
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Login',
        ));
    }


}

