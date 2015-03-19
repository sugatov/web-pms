<?php
namespace App\Services;

use RepositoryBasedService;
use Doctrine\Common\Persistence\ObjectManager;
use App\Model\Entities\Upload;
use App\Model\Entities\UploadImage;

class Uploads extends RepositoryBasedService
{
    /**
     * @var \App\Model\Repositories\Uploads
     */
    protected $repository;

    /**
     * @var string
     */
    protected $LOCAL_UPLOADS;

    /**
     * @var array
     */
    protected $imageMimeTypes;

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager, $LOCAL_UPLOADS)
    {
        parent::__construct($objectManager, 'App:Upload');
        if ( ! is_dir($LOCAL_UPLOADS)) {
            throw new \RuntimeException('Given directory actually is not a directory!');
        }
        $this->LOCAL_UPLOADS = $LOCAL_UPLOADS;
        $this->imageMimeTypes = array(
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/x-png',
            'image/gif',
            'image/tiff'
        );
    }

    public function newUpload()
    {
        return new Upload();
    }

    public function newUploadImage()
    {
        return new UploadImage();
    }

    public function delete($upload)
    {
        if ( ! $upload instanceof Upload) {
            $upload = $this->repository->find($upload);
        }
        if ( ! $upload) {
            throw new \RuntimeException('Не найден указанный объект!');
        }
        $filename = $this->LOCAL_UPLOADS . DIRECTORY_SEPARATOR . $upload->getFilename();
        $this->objectManager->remove($upload);
        $this->objectManager->flush();
        if (is_file($filename)) {
            if ( ! unlink($filename)) {
                throw new \RuntimeException('Ошибка удаления файла!');
            }
        }
    }

    public function upload($postName, $tag = null)
    {
        $storage = new \Upload\Storage\FileSystem($this->LOCAL_UPLOADS);
        $file = new \Upload\File($postName, $storage);
        $upload = null;
        if (in_array($file->getMimetype(), $this->imageMimeTypes)) {
            $upload = $this->newUploadImage();
            $imagesize = $file->getDimensions();
            $upload->setWidth($imagesize['width']);
            $upload->setHeight($imagesize['height']);
        } else {
            $upload = $this->newUpload();
        }
        $upload->setTag($tag);
        $upload->setMimeType($file->getMimetype());
        $upload->setOriginalFilename($file->getNameWithExtension());
        $file->setName(uniqid());
        $upload->setFilename($file->getNameWithExtension());
        $file->addValidations(array(
            // NOTE: макс.размер загружаемого файла
            new \Upload\Validation\Size('3M')
        ));
        if ($file->upload()) {
            $this->objectManager->persist($upload);
            $this->objectManager->flush();
            return $upload;
        } else {
            throw new \RuntimeException('Ошибка загрузки файла!');
        }
    }


}
