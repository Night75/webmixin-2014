<?php

namespace Night\DisplayBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Night\DisplayBundle\Entity\Image;
use Night\DisplayBundle\Entity\Image\ImageProject;
use Night\DisplayBundle\Entity\Project;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;

class LoadProjectData implements FixtureInterface
{
    /** @var ObjectManager */
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $this->em = $em;

        // Allopneus
//        $this->loadMobileAllopneus();
//        $this->loadAllopneusSecure();
//        $this->loadAllopneus();

        // Momindum
        $this->loadMakerLite();
        $this->loadStudioForLms();

        // Illusio
        $this->loadImmoExpress();
        $this->loadNatekko();
        $this->loadKMJ();
        $this->loadPhilia();

    }

    protected function loadImmoExpress()
    {
        $title = 'Immo Express';
        $description = "lala";
        $shortDesc = "Annonces immobilières";
        $imgPath = '/uploads/images/projects/immo_express_1.jpg';
        $this->loadBasic($title, $description, $shortDesc, $imgPath);
    }

    protected function loadNatekko()
    {
        $title = 'Natekko';
        $description = "lala";
        $shortDesc = "Promotion immobilière";
        $imgPath = '/uploads/images/projects/natekko_1.jpg';
        $this->loadBasic($title, $description, $shortDesc, $imgPath);
    }

    protected function loadPhilia()
    {
        $title = 'Philia';
        $description = "lala";
        $shortDesc = "Promotion immobilière";
        $imgPath = '/uploads/images/projects/philia_1.jpg';
        $this->loadBasic($title, $description, $shortDesc, $imgPath);
    }

    protected function loadKMJ()
    {
        $title = 'Karl Marc John';
        $description = "lala";
        $shortDesc = "E-commerce prêt à porter";
        $imgPath = '/uploads/images/projects/kmj_1.jpg';
        $this->loadBasic($title, $description, $shortDesc, $imgPath);
    }

    protected function loadEdouardDenis()
    {
        $title = 'Edouard Denis';
        $description = "lala";
        $shortDesc = "Extranet Immobilier";
        $imgPath = '/uploads/images/projects/edouard_denis_1.jpg';
        $this->loadBasic($title, $description, $shortDesc, $imgPath);
    }

    protected function loadStudioForLms()
    {
        $title = 'Studio For Lms';
        $description = "lala";
        $shortDesc = "Extranet";
        $imgPath = '/uploads/images/projects/studio_for_lms_1.jpg';
        $this->loadBasic($title, $description, $shortDesc, $imgPath);
    }

    protected function loadMakerLite()
    {
        $title = 'Maker Lite';
        $description = "lala";
        $shortDesc = "Application Rich Media";
        $imgPath = '/uploads/images/projects/maker_lite_1.jpg';
        $this->loadBasic($title, $description, $shortDesc, $imgPath);
    }


    protected function loadBasic($title, $description, $shortDescription, $imgPath)
    {
        $project = new Project();
        $project->setTitle($title);
        $project->setDescription($description);
        $project->setShortDescription($shortDescription);

        $image = new Image();
        $image->setPath($imgPath);

        $imageItem = new ImageProject();
        $imageItem->setImage($image);
        $imageItem->setOrder(1);

        $project->addImageItem($imageItem);

        $this->em->persist($project);
        $this->em->flush();
    }
}