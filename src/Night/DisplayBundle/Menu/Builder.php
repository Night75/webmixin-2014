<?php

namespace Night\DisplayBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function headMenu(FactoryInterface $factory, array $options)
    {
        $iconHome = '/bundles/nightdisplay/images/logo.svg';
        $tagImgHome = sprintf('<img src="%s" alt="home" />', $iconHome);

        $menu = $factory->createItem('root');

        $menu->addChild('header.skills', [
                'route' => 'page_home' ,
                'attributes' => ['class' => 'link']
            ]);
        $menu->addChild('header.projects', [
                'route' => 'page_home' ,
                'attributes' => ['class' => 'link']
            ]);
        $menu->addChild($tagImgHome, [
                'route' => 'page_contact',
                'attributes' => ['id' => 'link-home'],
                'extras' => ['safe_label' => true],
            ]
        );
        $menu->addChild('header.about_me', [
                'route' => 'page_home' ,
                'attributes' => ['class' => 'link']
            ]);
        $menu->addChild('header.contact', [
                'route' => 'page_contact' ,
                'attributes' => ['class' => 'link']
            ]);

        return $menu;
    }
}
