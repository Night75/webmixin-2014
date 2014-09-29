<?php

namespace Night\DisplayBundle\Util;

use Night\DisplayBundle\Model\Model\ImageItem;

class ImageUtil
{
    public static function getOrderedImages($item)
    {
        $images = [];
        foreach ($item->getImagesItem() as $imgItem) {
            $images[$imgItem->getOrder()] = $imgItem->getImage();
        }

        return $images;
    }
}