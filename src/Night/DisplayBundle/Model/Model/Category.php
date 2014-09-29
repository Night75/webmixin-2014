<?php

namespace Night\DisplayBundle\Model\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 */
class Category
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
     * @return Category
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
     * @var \Night\DisplayBundle\Entity\Image
     */
    private $category;


    /**
     * Set category
     *
     * @param \Night\DisplayBundle\Entity\Image $category
     * @return Category
     */
    public function setCategory(\Night\DisplayBundle\Entity\Image $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Night\DisplayBundle\Entity\Image 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
