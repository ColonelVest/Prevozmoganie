<?php

namespace BaseBundle\DataFixtures\ORM;

use BaseBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $fixturesUser = new User();
        $fixturesUser->setUsername('angry');
        $fixturesUser->setDisplayedName('angry stupid user');
        $fixturesUser->setEmail('user1@faaint.com');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($fixturesUser, $this->container->getParameter('fixtures_user_password'));
        $fixturesUser->setPassword($password);
        $fixturesUser->setEnabled(true);
        $fixturesUser->addRole('ROLE_USER');
        $manager->persist($fixturesUser);

        $fixturesUser2 = new User();
        $fixturesUser2->setUsername('good');
        $fixturesUser2->setDisplayedName('good-natured user');
        $fixturesUser2->setEmail('user2@faaint.com');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($fixturesUser2, $this->container->getParameter('fixtures_user_password'));
        $fixturesUser2->setPassword($password);
        $fixturesUser2->setEnabled(true);
        $fixturesUser2->addRole('ROLE_USER');
        $manager->persist($fixturesUser2);

        $fixturesUser3 = new User();
        $fixturesUser3->setUsername('kenedias');
        $fixturesUser3->setDisplayedName('danya odmin');
        $fixturesUser3->setEmail('faainttt@gmail.com');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($fixturesUser3, $this->container->getParameter('fixtures_admin_password'));
        $fixturesUser3->setPassword($password);
        $fixturesUser3->setEnabled(true);
        $fixturesUser3->addRole('ROLE_ADMIN');
        $manager->persist($fixturesUser3);

        $manager->flush();

        $this->addReference('fixt_user', $fixturesUser);
        $this->addReference('fixt_user2', $fixturesUser2);
        $this->addReference('fixt_admin', $fixturesUser3);
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