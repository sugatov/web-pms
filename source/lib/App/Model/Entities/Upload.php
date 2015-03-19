<?php
namespace App\Model\Entities;

/**
 * @Entity(repositoryClass="\App\Model\Repositories\Uploads")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="type", type="string", length=16)
 * @DiscriminatorMap({"Upload" = "Upload", "UploadImage" = "UploadImage"})
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
     * @Column(type="string", unique=true, nullable=false)
     */
    private $filename = null;
    
    /**
     * @Column(type="string", unique=false, nullable=false)
     */
    private $originalFilename = null;
    
    /**
     * @Column(type="string", unique=false, nullable=false)
     */
    private $mimeType = null;
    
    /**
     * @Column(type="string", unique=false, nullable=true)
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
