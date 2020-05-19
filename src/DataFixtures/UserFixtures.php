<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setName('Bruce W');
        $user1->setEnabled(true);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setName('Tim D');
        $user2->setEnabled(true);
        $manager->persist($user2);

        $formerUser2 = new User();
        $formerUser2->setName('Jason T');
        $formerUser2->setEnabled(false);
        $manager->persist($formerUser2);

        $manager->flush();
    }
}
