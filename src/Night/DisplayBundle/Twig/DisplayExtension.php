<?php

namespace Night\DisplayBundle\Twig;

class DisplayExtension extends \Twig_Extension
{
    /** @var string */
    protected $webDir;

    public function __construct($webDir)
    {
        $this->webDir = $webDir;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction("includeAsset", [$this, "includeAsset"]),
        ];
    }

    public function includeAsset($path)
    {
        return file_get_contents($this->webDir .$path);
    }

    public function getName()
    {
        return 'night_display_extension';
    }
}
