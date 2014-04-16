<?php

class Application_Model_Photo extends PhotoGallery_Model
{

    public function __construct($id = null)
    {
        parent::__construct(new Application_Model_DbTable_Photos, $id);
    }


    public function getPhotos($count = null)
    {
        return $this->_dbTable->fetchAll(null, 'created DESC', $count);
    }

    public function getAlbum()
    {
        return $this->_row->findParentRow(new Application_Model_DbTable_Albums());
    }

    public static function generateName($file)
    {
        $ext = strtolower(pathinfo($file['content']['name'], PATHINFO_EXTENSION));
        do {
            $name = substr(md5(microtime()), 0, 20);
            $fileName = $name . '.' . $ext;
        } while (file_exists(PHOTO_PATH . $fileName));
        return $fileName;
    }


    public function createPreview()
    {
        $maxSize = 250;
        $image = PHOTO_PATH . $this->filename;
        $imageTo = PHOTO_PATH . 'preview/' . $this->filename;

        $imageVars = getimagesize($image);
        $srcWidth = $imageVars[0];
        $srcHeight = $imageVars[1];
        $srcType = $imageVars[2];

        if ($srcWidth < $maxSize && $srcHeight < $maxSize) {
            copy($image, $imageTo);
            return true;
        }

        $ratio = ($srcWidth > $srcHeight) ? ($srcWidth / $maxSize) : ($srcHeight / $maxSize);
        $width = $srcWidth / $ratio;
        $height = $srcHeight / $ratio;
        $dstImage = imagecreatetruecolor($width, $height);

        switch ($srcType) {
            case IMAGETYPE_JPEG:
                $srcImage = imagecreatefromjpeg($image);
                imagecopyresized($dstImage, $srcImage, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
                imagejpeg($dstImage, $imageTo);
                break;
            case IMAGETYPE_GIF:
                $srcImage = imagecreatefromgif($image);
                imagecopyresized($dstImage, $srcImage, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
                imagegif($dstImage, $imageTo);
                break;
            case IMAGETYPE_PNG:
                $srcImage = imagecreatefrompng($image);
                imagecopyresized($dstImage, $srcImage, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
                imagepng($dstImage, $imageTo);
                break;
            default:
                return FALSE;
                break;
        }

    }

    public function delete()
    {
        unlink(PHOTO_PATH . $this->filename);
        unlink(PHOTO_PATH . 'preview/' . $this->filename);
        parent::delete();
    }

    public function populateForm()
    {
        return $this->_row->toArray();
    }


}

