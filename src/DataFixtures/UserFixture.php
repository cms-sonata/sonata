<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends AbstractFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function ($i) {
            $user = new User();

            $user->setEmail(sprintf(
                'email%d@domain.com', $i
            ));

            $user->setFirstName($this->faker->firstName);

            return $user;
        });

        $manager->flush();
    }
}