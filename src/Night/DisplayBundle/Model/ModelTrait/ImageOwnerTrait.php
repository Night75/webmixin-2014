<?php

namespace Night\DisplayBundle\Model\ModelTrait;

use Doctrine\Common\Collections\ArrayCollection;
use Night\DisplayBundle\Model\Model\ImageItem;
use Night\DisplayBundle\Model\Model\Image;

trait ImageOwnerTrait
{
    /**
     * @return Image[]
     */
    public function getImages()
    {
        $images = [];
        foreach ($this->getImagesItem() as $imageItem) {
            $images[$imageItem->getOrder()] = $imageItem;
        }

        return $images;
    }
}