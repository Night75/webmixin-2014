<?php

namespace Night\DisplayBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Night\DisplayBundle\Entity\Image;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadImageData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** @var ObjectManager */
    protected $em;
    /** @var string */
    protected $imgRootDir;
    /** @var ContainerInterface */
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $this->em = $em;
        $this->imgRootDir = $this->container->getParameter('web_dir');

        // Languages Images
        $this->loadSvg('/uploads/images/languages/php.svg', 'img-php');
        $this->loadSvg('/uploads/images/languages/c-sharp.svg', 'img-c-sharp');
        $this->loadSvg('/uploads/images/languages/css.svg', 'img-css');
        $this->loadSvg('/uploads/images/languages/html.svg', 'img-html');
        $this->loadSvg('/uploads/images/languages/html5.svg', 'img-html5');
        $this->loadSvg('/uploads/images/languages/javascript.svg', 'img-javascript');
        $this->loadSvg('/uploads/images/languages/jquery.svg', 'img-jquery');
        $this->loadSvg('/uploads/images/languages/less.svg', 'img-less');
        $this->loadSvg('/uploads/images/languages/nodejs.svg', 'img-nodejs');
        $this->loadSvg('/uploads/images/languages/symfony.svg', 'img-symfony');
    }

    protected function loadSvg($path, $reference)
    {
        $image = new Image();
        $image->setPath($path);
        $image->setDataType(Image::DATA_TYPE_SVG);
        $image->setData(file_get_contents($this->imgRootDir .$path));
        $this->addReference($reference, $image);

        $this->em->persist($image);
        $this->em->flush();
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}