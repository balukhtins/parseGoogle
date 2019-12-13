<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
        $this->_helper->redirector('parser', 'index');
    }

        $db = $this->_getParam('db');

        $loginForm = new Application_Auth_Form_Login();

        if ($loginForm->isValid($_POST)) {

            $adapter = new Zend_Auth_Adapter_DbTable(
                $db,
                'users',
                'username',
                'password',
                'MD5(CONCAT(?, password_salt))'
            );

            $adapter->setIdentity($loginForm->getValue('username'));
            $adapter->setCredential($loginForm->getValue('password'));

            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);

            if ($result->isValid()) {
                $this->_helper->FlashMessenger('Successful Login');
                $this->_redirect('/');
                return;
            }
        }
    }

    public function logoutAction()
    {
        // action body
    }


}





