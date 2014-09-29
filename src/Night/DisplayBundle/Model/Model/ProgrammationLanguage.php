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
    protected $imagesItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->imagesItem = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add imagesItem
     *
     * @param ImageItem $imagesItem
     * @return ProgrammationLanguage
     */
    public function addImageItem(ImageItem $imagesItem)
    {
        $this->imagesItem[] = $imagesItem;
        $imagesItem->setItem($this);

        return $this;
    }

    /**
     * Remove imagesItem
     *
     * @param ImageItem $imagesItem
     */
    public function removeImageItem(ImageItem $imagesItem)
    {
        $this->imagesItem->removeElement($imagesItem);
    }

    /**
     * Get imagesItem
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImagesItem()
    {
        return $this->imagesItem;
    }
}
