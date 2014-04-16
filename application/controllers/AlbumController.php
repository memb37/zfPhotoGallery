<?php

class AlbumController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $this->view->title = "Альбомы";
        $this->view->headTitle($this->view->title, 'PREPEND');

        $albums = new Application_Model_Album();
        $this->view->albums = $albums->getAlbums();
    }

    public function viewAction()
    {
        $this->view->title = 'Просмотр альбома';
        $this->view->headTitle($this->view->title, 'PREPEND');

        $id = $this->_getParam('id');
        $album = new Application_Model_Album($id);
        $photos = $album->getPhotos();
        $this->view->album = $album;
        $this->view->photos = $photos;
    }

    public function addAction()
    {
        $this->view->title = "Добавление альбома";
        $this->view->headTitle($this->view->title, 'PREPEND');

        $form = new Application_Form_Album();
        $form->submit->setLabel('Добавить');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $album = new Application_Model_Album();
                $album->fill($form->getValues());
                $album->created = date('Y-m-d');
                $album->modified = date('Y-m-d');
                $album->save();

                $this->_helper->redirector('index');
            }
        }
        $this->view->form = $form;
    }

    public function editAction()
    {
        $this->view->title = "Редактирование альбома";
        $this->view->headTitle($this->view->title, 'PREPEND');

        $id = $this->_getParam('id');
        $album = new Application_Model_Album($id);
        $form = new Application_Form_Album();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $album->fill($form->getValues());
                $album->modified = date('Y-m-d');
                $album->save();
                $this->_helper->redirector('view', null , null, array('id' => $album->id));
            }
        } else {
            $form->populate($album->populateForm());
        }
        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $id = $this->_getParam('id');
        $album = new Application_Model_Album($id);
        $album->delete();
        $this->_helper->redirector('index');
    }


}







