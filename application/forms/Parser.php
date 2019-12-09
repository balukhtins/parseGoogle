<?php

class Application_Form_Parser extends Zend_Form
{

    public function init()
    {
        $this -> setMethod ( 'post' )
              ->setAction('/parser/index');

        // $isEmptyMessage = 'Значение является обязательным и не может быть пустым';
        // Задаём имя форме
        //$this->setName('parser');

        // Add an domain element
        $this->addElement('text', 'domain', array(
            'label'      => 'Домен',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'Hostname',
            )
        ));

        // Add an word element
         $this->addElement('text', 'word', array(
             'label'      => 'Ключевое слово',
             'required'   => true,
             'filters'    => array('StringTrim'),
             'validators' => array(
                 'NotEmpty')
         ));

         // Add the submit button
         $this->addElement('submit', 'submit', array(
             'ignore'   => true,
             'label'    => 'Запросить',
         ));

         $this->addElement('hash', 'csrf'/*, array(
             'ignore' => true,
         )*/);

    }

}

