<?php

class Application_Form_Delete extends Zend_Form
{
   public function init()
    {
        $this -> setMethod ( 'post' )
            ->setAction('/parser/delete')
            ->setAttrib('class', 'btn btn-outline-danger');

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Удалить',
        ))->setAttrib('id', 'delete');

        $this->addElement('hidden', 'id')->setAttrib('value', '<?php echo $this->escape($this->id);?>');

        $this->addElement('hash', 'csrf'/*, array(
             'ignore' => true,
         )*/);
    }
}

