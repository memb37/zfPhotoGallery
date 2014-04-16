<?php

class PhotoController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $this->view->title = "Фотографии";
        $this->view->headTitle($this->view->title, 'PREPEND');

        $photos = new Application_Model_Photo();
        $this->view->photos = $photos->getPhotos();
    }

    public function viewAction()
    {
        $this->view->title = "Просмотр фотографии";
        $this->view->headTitle($this->view->title, 'PREPEND');

        $photo = new Application_Model_Photo($this->_getParam('id'));
        $this->view->photo = $photo;
        $this->view->album = $photo->getAlbum();

    }

    public function addAction()
    {
        $this->view->title = "Добавление фотографии";
        $this->view->headTitle($this->view->title, 'PREPEND');


        $form = new Application_Form_Photo();

        if ($id = $this->_getParam('id')) {
            $album = new Application_Model_Album($id);
            $form->album_id->addMultiOption($album->id, $album->title);
        } else {
            $albums = new Application_Model_Album();
            $list = $albums->getAlbums();
            foreach ($list as $album) {
                $form->album_id->addMultiOption($album->id, $album->title);
            }
        }
        if ($form->album_id->options) {
            $form->submit->setLabel('Добавить');
            $this->view->form = $form;
        }


        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

                $file = $form->content->getFileInfo();
                $newName = Application_Model_Photo::generateName($file);
                $form->content->addFilter('Rename', $newName);

                $photo = new Application_Model_Photo();
                $photo->fill($form->getValues());
                $photo->created = date('Y-m-d H:i:s');
                $photo->filename = $newName;

                $photo->createPreview();
                $photo->save();

                $this->_helper->redirector('view', 'album', null, array('id' => $photo->album_id));
            }
        }
    }

    public function deleteAction()
    {
        $id = $this->_getParam('id');
        $photo = new Application_Model_Photo($id);
        $photo->delete();
        if ($album_id = $this->_getParam('album_id')) {
            $this->_helper->redirector('view', 'album', null, array('id' => $album_id));
        }
        $this->_helper->redirector('index');
    }


}



