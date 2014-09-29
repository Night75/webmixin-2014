<?php

namespace Night\DisplayBundle\Model\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryItem
 */
class CategoryItem
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $itemType;

    /**
     * @var object
     */
    protected $item;

    /**
     * @var integer
     */
    protected $category;

    /**
     * Set itemType
     *
     * @param string $itemType
     * @return CategoriesItem
     */
    public function setItemType($itemType)
    {
        $this->itemType = $itemType;

        return $this;
    }

    /**
     * Get itemType
     *
     * @return string
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    /**
     * Set item
     *
     * @param object $item
     * @return CategoriesItem
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return integer
     */
    public function getItem()
    {
        return $this->item;
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
     * Set category
     *
     * @param integer $category
     * @return CategoriesItem
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return integer
     */
    public function getCategory()
    {
        return $this->category;
    }
}
