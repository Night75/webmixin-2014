<?php

namespace Night\DisplayBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Night\DisplayBundle\Entity\Category;
use Night\DisplayBundle\Entity\Image;
use Night\DisplayBundle\Entity\Image\ImageProject;
use Night\DisplayBundle\Entity\Project;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadProjectData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
       $this->loadAllopneusMobile();
//        $this->loadAllopneusSecure();
       $this->loadAllopneus();

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
        $description = <<<EODT
Refonte du site d'annonce immobilière. Les objectifs sont la refonte graphique du site historique
pour un design moderne tout en gardant la compatibilité sur les navigateurs courants. Le backoffice a droit à une refonte pour 
une interface plus intuitive.
EODT;
        $technicalPoints = <<<EOT
<ul>
<li>Site compatible IE7+</li>
<li>Migration de la base donnée vers un nouveau modèle</li>
<li>Récupération des annonces via le service web Gercop</li>
</ul>'
EOT;
        $shortDesc = "Annonces immobilières";
        $imgPath = '/uploads/images/projects/immo_express_1.jpg';
        $category = "project-vitrine";
        $this->loadBasic($title, $description, $shortDesc, $imgPath, $category);
    }

    protected function loadNatekko()
    {
        $title = 'Natekko';
        $description = <<<EODT
Refonte du site vitrine.
EODT;
        $technicalPoints = <<<EOT
<ul>
<li>Site compatible IE7+</li>
</ul>'
EOT;
        $shortDesc = "Promotion immobilière.";
        $imgPath = '/uploads/images/projects/natekko_1.jpg';
        $category = "project-vitrine";
        $this->loadBasic($title, $description, $shortDesc, $imgPath, $category);
    }

    protected function loadPhilia()
    {
        $title = 'Philia';
        $description = <<<EODT
        Refonte du site vitrine. Les objectifs sont la refonte graphique du site historique 
pour un design moderne tout en gardant la compatibilité sur les navigateurs courants. Le backoffice a droit à une refonte pour 
une interface plus intuitive.
EODT;
        $technicalPoints = <<<EROT
<ul>
<li>Site compatible IE7+</li>
<li>Migration de la base donnée vers un nouveau modèle</li>
</ul>
EROT;
        $shortDesc = "Promotion immobilière";
        $imgPath = '/uploads/images/projects/philia_1.jpg';
        $category = "project-vitrine";
        $this->loadBasic($title, $description, $shortDesc, $imgPath, $category);
    }

    protected function loadKMJ()
    {
        $title = 'Karl Marc John';
        $description = <<<EODT
        Site E-commerce de prêt à porter féminin. Le site a été créé à l'aide du CMS Magento qui fournit 
la majorité des fonctionnalités recherchées. Néanmoins certains développements spécifiques sont nécessaires 
pour répondre aux besoins métiers.
EODT;
        $technicalPoints = <<<EOT 
<ul>
<li>Assistance pour la prise en main du CMS Magento</li>
<li>Développement de modules personnalisés</li>
<li>Intégration de templates</li>
</ul>'
EOT;
        $shortDesc = "E-commerce prêt à porter";
        $imgPath = '/uploads/images/projects/kmj_1.jpg';
        $category = "project-e-commerce";
        $this->loadBasic($title, $description, $shortDesc, $imgPath, $category);
    }

    protected function loadEdouardDenis()
    {
        $title = 'Edouard Denis';
        $description = <<<EODT
Extranet immobilier. L'application permet d'administrer de consulter et gérer des lots immobilier.
Egalement de générer des documents pré remplis tenant compte des différentes règles de fiscalité
EODT;
        $technicalPoints = <<<EOT 
<ul>
<li>Développement de diverses features</li>
</ul>'
EOT;
        $shortDesc = "Extranet Immobilier";
        $imgPath = '/uploads/images/projects/edouard_denis_1.jpg';
        $category = "project-extranet";
        $this->loadBasic($title, $description, $shortDesc, $imgPath, $category);
    }

    protected function loadStudioForLms()
    {
        $title = 'Studio For Lms';
        $description = "Extranet des clients de Momindum Maker, Maker Lite (Application de création de contenu Rich Media).
Cette plateforme permet de gérer le compte, consulter les factures, les statistiques de vidéos etc... 
L'application comprend une partie front et backoffice.";
        $technicalPoints = <<<EOT 
<ul>
<li>Conception de la base de données</li>
<li>Utilisations de l'API Momindum et API Momindum</li>
</ul>'
EOT;
        $shortDesc = "Extranet";
        $imgPath = '/uploads/images/projects/studio_for_lms_1.jpg';
        $category = "project-extranet";
        $this->loadBasic($title, $description, $shortDesc, $imgPath, $category);
    }

    protected function loadMakerLite()
    {
        $title = 'Maker Lite';
        $description = "SAAS permet de créer du contenu Rich media. Le produit final est une vidéo synchronisée 
avec une présentation powerpoint pour laquelle toutes informations clés sont extraites et indexées.";
        $technicalPoints = <<<EOT 
<ul>
<li>Applications Front en PHP/Symfony 2, jQuery</li>
<li>Serveur de notification en NodeJS</li>
<li>Application de traitement vidéo et powerpoint en C#</li>
</ul>'
EOT;
        $shortDesc = "Application Rich Media";
        $imgPath = '/uploads/images/projects/maker_lite_1.jpg';
        $category = "project-software";
        $this->loadBasic($title, $description, $shortDesc, $imgPath, $category);
    }

    protected function loadAllopneusMobile()
    {
        $title = 'Edouard Denis';
        $description = "Site mobile E-commerce de vente de pneus. 
L'objectif de ce site est d'optimiser les ventes pour les utilisateurs de smartphone par une web app à l'interface optimisée et épurée. 
Du côté technique, l'objectif était de construire une architecture propre, extensible qui remplacera l'ancien développement difficilement maintenable.";
        $technicalPoints = <<<EOT 
<ul>
<li>Développement d'une architecture REST</li>
<li>Caches OPCodes, applicatif, HTTP, ESI</li>
<li>Développement de librairies javascript</li>
</ul>'
EOT;
        $shortDesc = "Site mobile";
        $imgPath = '/uploads/images/projects/mallopneus_1.jpg';
        $category = "project-e-commerce";
        $this->loadBasic($title, $description, $shortDesc, $imgPath, $category);
    }

    protected function loadAllopneus()
    {
        $title = 'Edouard Denis';
        $description = "Site E-commerce leader dans la vente de pneus. Refonte de la partie jante du site desktop. 
L'objectif fonctionnel est de pouvoir identifier les jantes d'un vehicule donné compatibles avec les pneus sélectionnés.";
        $technicalPoints = <<<EOT 
<ul>
<li>Mise en place du moteur de recherche Solr</li>
<li>Développement/Optimisation du bash d'indexation des produits</li>
<li>Développement de bundles symfony commun à toutes les sites front Allopneus</li>
</ul>'
EOT;
        $shortDesc = "Site E-commerce";
        $imgPath = '/uploads/images/projects/allopneus_1.jpg';
        $category = "project-e-commerce";
        $this->loadBasic($title, $description, $shortDesc, $imgPath, $category);
    }

    protected function loadBasic($title, $description, $shortDescription, $imgPath, $category)
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

        $categoryProject = new Category\CategoryProject();
        $categoryProject->setCategory($this->getReference($category));
        $project->setCategoryItem($categoryProject);

        $this->em->persist($project);
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
        return 15;
    }
}