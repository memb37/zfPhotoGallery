<?php

class IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $this->view->title = "Главная";
        $this->view->headTitle($this->view->title, 'PREPEND');

        $albums = new Application_Model_Album();
        $this->view->albums = $albums->getAlbums(3);
        $photos = new Application_Model_Photo();
        $this->view->photos = $photos->getPhotos(5);
    }


}