<?php



class ParserController extends Zend_Controller_Action
{
    //use My_Services_Parser;



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
        require_once 'Services/Parser.php';
        $pars = new Services_Parser;
        $request = $this->getRequest();

        $data = ['form' => new Application_Form_Parser()];

        if ($this->getRequest()->isPost()) {
            if ($data['form']->isValid($request->getPost())) {

              $post = $data['form']->getValues();
              unset($post['csrf']);
              $parser = $pars->parser($post);

              if (!isset($parser))$parser='Not found';

              $post['position'] = $parser;
              $add = new Application_Model_DbTable_Parser();
              $add->setParser($post);
              $data ['comment'] = 'Домен "'. $post['domain'] . '" по ключевому слову "' . $post['word'] . '" находится на ' . $post['position'] . ' позиции в выдаче Google';
             }
        }

        $this->view->data = $data;
    }

    public function showAction()
    {
            $paginator = new Application_Model_DbTable_Parser();

            $this->view->paginator = $paginator->getPaginatorRows((int) $this->getRequest()->getParam('page', 1));
   }

}



