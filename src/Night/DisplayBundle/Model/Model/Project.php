<?php

namespace Night\DisplayBundle\Model\Model;

use Doctrine\ORM\Mapping as ORM;
use Night\DisplayBundle\Model\ModelTrait\ImageOwnerTrait;

/**
 * Project
 */
class Project
{
    use ImageOwnerTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $shortDescription;

    /**
     * @var string
     */
    protected $technicalPoints;

    /**
     * @var ImageItem
     */
    protected $imagesItem;

    /**
     * @var CategoryItem
     */
    protected $categoryItem;

    /**
     * @var WebTechnology[]
     */
    protected $webTechnologies;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->imagesItem = new \Doctrine\Common\Collections\ArrayCollection();
        $this->webTechnologies = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Project
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getTechnicalPoints()
    {
        return $this->technicalPoints;
    }

    /**
     * @param string $technicalPoints
     */
    public function setTechnicalPoints($technicalPoints)
    {
        $this->technicalPoints = $technicalPoints;
    }

    /**
     * Set imagesItem
     *
     * @param ImageItem $imagesItem
     *
     * @return Project
     */
    public function setImagesItem(ImageItem $imagesItem = null)
    {
        $this->imagesItem = $imagesItem;

        return $this;
    }

    /**
     * Get imagesItem
     *
     * @return ImageItem
     */
    public function getImagesItem()
    {
        return $this->imagesItem;
    }

    /**
     * Add imagesItem
     *
     * @param ImageItem $imagesItem
     *
     * @return Project
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
     * Set shortDescription
     *
     * @param string $shortDescription
     *
     * @return Project
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @return CategoryItem
     */
    public function getCategoryItem()
    {
        return $this->categoryItem;
    }

    /**
     * @param CategoryItem $categoryItem
     */
    public function setCategoryItem(CategoryItem $categoryItem)
    {
        $this->categoryItem = $categoryItem;
    }


    /**
     * Set webTechnology
     *
     * @param WebTechology $webTechnology
     *
     * @return Project
     */
    public function setWebTechologies($webTechnologies)
    {
        $this->webTechnologies = $webTechnologies;

        return $this;
    }

    /**
     * Get webTechnology
     *
     * @return WebTechnology
     */
    public function getWebTechnologies()
    {
        return $this->webTechnologies;
    }

    /**
     * Add webTechnology
     *
     * @param WebTechnology $webTechnology
     *
     * @return Project
     */
    public function addWebTechnology(WebTechnology $webTechnology)
    {
        $this->webTechnologies[] = $webTechnology;

        return $this;
    }

    /**
     * Remove webTechnologies
     *
     * @param WebTechology $webTechnologies
     */
    public function removeWebTechology(WebTechology $webTechnologies)
    {
        $this->webTechnologies->removeElement($webTechnologies);
    }
}
