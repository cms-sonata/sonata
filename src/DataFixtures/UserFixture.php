<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends AbstractFixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {

        $this->passwordEncoder = $passwordEncoder;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function ($i) {
            $user = new User();

            $user->setEmail($this->faker->email);

            $user->setFirstName($this->faker->firstName);
            $user->setPassword($this->passwordEncoder->encodePassword($user,'password'));
            $user->agreeTerms();

            return $user;
        });

        $this->createMany(3, 'admin_users', function ($i) {
            $user = new User();

            $user->setEmail(sprintf('admin%d@lol.com', $i));
            $user->setRoles(['ROLE_ADMIN']);

            $user->setFirstName($this->faker->firstName);
            $user->setPassword($this->passwordEncoder->encodePassword($user,'password'));
            $user->agreeTerms();

            return $user;
        });

        $manager->flush();
    }
}
