<?php

namespace Night\DisplayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Night\DisplayBundle\Entity\Image\ImageProject;
use Night\DisplayBundle\Model\Model\Project as BaseProject;

/**
 * Project
 */
class Project extends BaseProject
{
    /**
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    protected $locale;

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
}
