<?php

namespace Night\DisplayBundle\Model\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProgrammationLanguage
 */
class ProgrammationLanguage
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var ImageItem
     */
    protected $imageItem;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ProgrammationLanguage
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ImageItem
     */
    public function getImageItem()
    {
        return $this->imageItem;
    }

    /**
     * @param ImageItem $imageItem
     */
    public function setImageItem($imageItem)
    {
        $this->imageItem = $imageItem;
    }
}
