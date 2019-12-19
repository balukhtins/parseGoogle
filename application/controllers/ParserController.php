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
        $contextSwitch = $this->_helper->contextSwitch;
        $contextSwitch->addActionContext('show', 'json')->initContext();
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
                        $post['position']='Not Found';
                    }
                  $data ['comment'] = 'Домен "'. $post['domain'] . '" по ключевому слову "' . $post['word'] . '" находится на ' . $post['position'] . ' позиции в выдаче Google';
            }
        }
        $this->view->data = $data;
    }

    public function showAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()){
            if( $this->getRequest()->getPost('id')){
            $id = $this->getRequest()->getPost('id');
            $page = $this->getRequest()->getPost('page');
            $this->deleteAction($id, $page);
            }

            $layout = $this -> _helper-> layout( ) ;
            $layout -> disableLayout( ) ;
        }
        $desc = 'DESC';
        $itemCountPerPage = 10;
        $paginator = new Application_Model_ParserShow();

        $this->view->paginator =  $paginator->getPaginatorRows((int) $this->getRequest()->getParam('page', 1),$itemCountPerPage,$desc);
    }

    public function deleteAction($id, $page)
    {
        $param['id'] = $id;
        $delete = new Application_Model_Parser( $param);
        $del = new Application_Model_ParserShow();
        $del->delete($delete);

       $this->_helper->redirector->gotoUrl('parser/show/page/'.$page);
        //$this->_forward('show', null, null, array('page'=>$page));
    }
}
