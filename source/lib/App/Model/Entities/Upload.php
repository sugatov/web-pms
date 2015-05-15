<?php
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;

/**
 * @ORM\Entity(repositoryClass="\App\Model\Repositories\Uploads")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=16)
 * @ORM\DiscriminatorMap({"Upload" = "Upload", "UploadImage" = "UploadImage"})
 */
class Upload extends Super\IntegerID
{
    private $_type = null;
    public function getType()
    {
        if ($this->_type == null) {
            $type = explode('\\', get_class($this));
            $this->_type = end($type);
        }
        return $this->_type;
    }
    public function setType($type)
    {
        if (in_array($type, array('Upload', 'UploadImage'))) {
            $this->_type = $type;
        } else {
            throw new ValidationException('Неверный тип загруженного файла!');
        }
    }

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $filename = null;
    
    /**
     * @ORM\Column(type="string", unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $originalFilename = null;
    
    /**
     * @ORM\Column(type="string", unique=false, nullable=false)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $mimeType = null;
    
    /**
     * @ORM\Column(type="string", unique=false, nullable=true)
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    private $tag = null;

    /**
     * Set filename
     *
     * @param string $filename
     * @return Upload
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set originalFilename
     *
     * @param string $originalFilename
     * @return Upload
     */
    public function setOriginalFilename($originalFilename)
    {
        $this->originalFilename = $originalFilename;

        return $this;
    }

    /**
     * Get originalFilename
     *
     * @return string 
     */
    public function getOriginalFilename()
    {
        return $this->originalFilename;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     * @return Upload
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string 
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set tag
     *
     * @param string $tag
     * @return Upload
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }
}
