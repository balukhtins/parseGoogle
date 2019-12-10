<?php

class ParserController extends Zend_Controller_Action
{
    public function init()
    {
        Zend_Loader::loadClass('Zend_Filter_StripTags');
        Zend_Loader::loadClass('Zend_Paginator');
        Zend_Loader::loadClass('Zend_Paginator_Adapter_array');
        Zend_Loader::loadClass('Zend_View_Helper_PaginationControl');
        Zend_Loader::loadClass('Zend_Loader_Autoloader_Resource');
    }
    public function indexAction()
    {
        require_once 'Services/parser.php';
        $pars = new Services_Parser;
        $request = $this->getRequest();
        $data = ['form' => new Application_Form_Parser()];

        if ($this->getRequest()->isPost()) {
            if ($data['form']->isValid($request->getPost())) {
                  $post = $data['form']->getValues();
                  unset($post['csrf']);
                  $parser = $pars->parser($post);
                      if (!isset($parser)){
                         $parser=-1;
                      }
                  $post['position'] = $parser;
                  $save = new Application_Model_Parser($post);
                  $add = new Application_Model_ParserShow();
                  $add->save($save);
                    if ($parser == -1){
                        $parser='Not Found';
                    }
                  $data ['comment'] = 'Домен "'. $post['domain'] . '" по ключевому слову "' . $post['word'] . '" находится на ' . $post['position'] . ' позиции в выдаче Google';
            }
        }
        $this->view->data = $data;
    }
    public function showAction()
    {
        $desc = 'DESC';
        $itemCountPerPage = 10;
        $paginator = new Application_Model_ParserShow();
        $this->view->paginator = $paginator->getPaginatorRows((int) $this->getRequest()->getParam('page', 1),$itemCountPerPage,$desc);
   }
}



