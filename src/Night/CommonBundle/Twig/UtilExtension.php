<?php

namespace Night\CommonBundle\Twig;

class UtilExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('integerPart', [$this, 'integerPart']),
            new \Twig_SimpleFilter('decimalPart', [$this, 'decimalPart']),
            new \Twig_SimpleFilter('ratingToPercentage', [$this, 'ratingToPercentage']),
            new \Twig_SimpleFilter('truncateText', [$this, 'truncateText']),
        );
    }

    /**
     * Get the intger part of a number
     *
     * @param  mixed $number
     * @return integer
     */
    public function integerPart($number)
    {
        // There is a bug on floor function. This is the preferred way to get the integer part
        list($whole, $decimal) = explode('.', $number);
        return $whole;
    }

    /**
     * Get the decimal part of a number
     *
     * @param  mixed $number
     * @return integer
     */
    public function decimalPart($number)
    {
        list($whole, $decimal) = explode('.', $number);
        return $decimal;
    }

    /**
     * Converts a rating to a percentage
     *
     * @param  mixed   $rating
     * @param  mixed   $maxRating Maximum rating possible
     * @param  integer $decimals Number of decimals to return
     * @return double
     */
    public function ratingToPercentage($rating, $maxRating, $decimals = 0)
    {
        $percentage = $rating/$maxRating*100;

        if ($decimals) {
            return number_format($percentage, $decimals);
        }
        return round($percentage);
    }

    /**
     * Truncate a text
     *
     * @param  mixed $number
     * @return integer
     */
    public function truncateText($text, $lengthLimit)
    {
        if (strlen($text) <= $lengthLimit) {
            return $text;
        }

        return mb_substr($text, 0, $lengthLimit, 'utf-8') . '...';
    }

    public function getName()
    {
        return 'night_util_extension';
    }
}
