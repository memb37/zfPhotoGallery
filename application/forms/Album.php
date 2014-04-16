<?php

class Application_Form_Album extends Zend_Form
{

    public function __construct()
    {

        parent::__construct();
        $this->setName('form_album');

        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Название альбома:*')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('StringLength', false, array(1, 50));


        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Описание альбома:*')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('StringLength', false, array(1, 200));


        $author = new Zend_Form_Element_Text('author');
        $author->setLabel('Имя фотографа:*')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('StringLength', false, array(1, 50));


        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email:')
            ->addFilter('StringTrim')
            ->addValidator('EmailAddress');

        $phone = new Zend_Form_Element_Text('phone');
        $phone->setLabel('Телефон в формате +7(xxx)xxx-xx-xx')
            ->addFilter('StringTrim')
            ->addValidator('Regex', false, array('/^(\+7\()\d{3}\)\d{3}(\-\d{2}){2}$/'));


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($title, $description, $author, $email, $phone, $submit));
    }


}

