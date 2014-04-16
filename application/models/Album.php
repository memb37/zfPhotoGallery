<?php
class Application_Model_Album extends PhotoGallery_Model
{

    public function __construct($id = null)
    {
        parent::__construct(new Application_Model_DbTable_Albums, $id);
    }

    public function getAlbums($limit = null)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $photosSorted = $db->select()
            ->from('photos')
            ->order('created DESC');

        $select = $db->select()
            ->from(array('a' => 'albums'))
            ->joinleft(array('p' => $photosSorted), 'p.album_id = a.id',
                array('photos_count' => 'COUNT(p.id)',
                      'preview' => 'p.filename', 'last_photo' => 'p.created'))
            ->group('a.id')
            ->order('p.created DESC')
            ->limit($limit);
        $stmt = $db->query($select);
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function getPhotos()
    {
        return $this->_row->findDependentRowset(
            new Application_Model_DbTable_Photos(),
            'Album'
        );
    }

    public function delete()
    {
        $photos = $this->getPhotos();
        foreach($photos as $row) {
            $photo = new Application_Model_Photo($row['id']);
            $photo->delete();
        }
        parent::delete();
    }

    public function populateForm()
    {
        return $this->_row->toArray();
    }

}

