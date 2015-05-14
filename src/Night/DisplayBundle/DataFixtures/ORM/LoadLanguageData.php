<?php

namespace Night\DisplayBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Night\DisplayBundle\Entity\Image;
use Night\DisplayBundle\Entity\ProgrammationLanguage;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadLanguageData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** @var ObjectManager */
    protected $em;
    /** @var  ContainerInterface */
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $this->em = $em;

        $this->loadBasic('php', 'img-php');
        $this->loadBasic('c-sharp', 'img-c-sharp');
        $this->loadBasic('css', 'img-css');
        $this->loadBasic('html', 'img-html');
        $this->loadBasic('html5', 'img-html5');
        $this->loadBasic('javascript', 'img-javascript');
        $this->loadBasic('jquery', 'img-jquery');
        $this->loadBasic('less', 'img-less');
        $this->loadBasic('nodejs', 'img-nodejs');
        $this->loadBasic('symfony', 'img-symfony');
    }

    protected function loadBasic($name, $imgReference)
    {
        $language = new ProgrammationLanguage();
        $language->setName($name);

        $imgItem = new Image\ImageProgrammationLanguage();
        $imgItem->setImage($this->getReference($imgReference));
        $imgItem->setOrder(1);

        $language->setImageItem($imgItem);

        $this->em->persist($language);
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
    function getOrder()
    {
        return 5;
    }
}