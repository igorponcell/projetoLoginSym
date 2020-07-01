<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('admin');
        $user->setAge('18');
        $user->setMail('admin@admin.com');
        $user->setLogin('admin');
        $user->setPassword($this->encoder->encodePassword($user, '123456'));

        $manager->persist($user);
        $manager->flush();
    }
}
