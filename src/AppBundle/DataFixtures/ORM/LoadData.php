<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Nelmio\Alice\Fixtures;

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
        $objects = Fixtures::load(__DIR__.'/data/fixtures.yml', $manager, array('providers' => array($this)));

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
}
