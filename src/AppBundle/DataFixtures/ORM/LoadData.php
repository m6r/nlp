<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $prefix = $this->container->getParameter('table_prefix');
        // The main category cannot be insert as an entity
        // Reset auto increment
        $sql = 'ALTER TABLE '.$prefix.'categories AUTO_INCREMENT = 1';
        $manager->getConnection()->prepare($sql)->execute();
        // We need id = 0 so NO_AUTO_VALUE_ON_ZERO must be activated in Mysql SQL mode
        // We save the old mode to rest it after.
        $sql = 'SELECT @@SESSION.sql_mode as mode';
        $query = $manager->getConnection()->prepare($sql);
        $query->execute();
        $mode = $query->fetch();
        // Set NO_AUTO_VALUE_ON_ZERO
        $sql = 'SET SESSION sql_mode="NO_AUTO_VALUE_ON_ZERO"';
        $manager->getConnection()->prepare($sql)->execute();
        // Do the insert
        $sql = 'INSERT INTO '.$prefix.'categories (category__auto_id, category_lang,
            category_id, category_parent, category_name, category_safe_name, rgt, lft,
            category_enabled, category_desc, category_keywords) VALUES (0, "en", 0, 0,
            "all", "all", 1, 0, 2, "", "")';
        $manager->getConnection()->prepare($sql)->execute();
        // Set back the old value
        $sql = 'SET SESSION sql_mode="'.$mode['mode'].'"';
        $manager->getConnection()->prepare($sql)->execute();

        $objects = Fixtures::load(__DIR__.'/data/fixtures.yml', $manager, array('providers' => array($this)));
        $manager->flush();

        $objects = Fixtures::load(__DIR__.'/data/fixtures2.yml', $manager, array('providers' => array($this)));
        $manager->flush();
    }

    public function hashedPassword($password = null)
    {
        $faker = \Faker\Factory::create();

        $user = new \AppBundle\Entity\User();
        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($user)
        ;

        return $encoder->encodePassword($password ?: $faker->word);
    }

    public function phoneNumberVO($phoneNumber)
    {
        $phoneUtil = $this->container->get('libphonenumber.phone_number_util');

        try {
            return $phoneUtil->parse($phoneNumber, 'FR');
        } catch (\Exception $e) {
            return null;
        }
    }
}
