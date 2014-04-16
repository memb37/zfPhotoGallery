<?php

class Application_Form_Photo extends Zend_Form
{

    public function __construct()
    {
        parent::__construct();
        $this->setName('form_photo');
        $this->setAttrib('enctype', 'multipart/form-data');

        $album = new Zend_Form_Element_Select('album_id');
        $album->setLabel('Альбом');


        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Название фотографии:*')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator('StringLength', false, array(0, 50));


        $author = new Zend_Form_Element_Text('address');
        $author->setLabel('Адрес фотосъемки:')
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('StringLength', false, array(0, 200));

        $content = new Zend_Form_Element_File('content');
        $content->setLabel('Загружаемый файл:*')
            ->setDestination(APPLICATION_PATH . '/../public/photos')
            ->setRequired(true)
            ->addValidator('Count', false, 1)
            ->addValidator('Extension', false, array('jpg', 'gif', 'png'))
            ->addValidator('Size', false, 20971520);


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($album, $title, $author, $content, $submit));
    }


}

