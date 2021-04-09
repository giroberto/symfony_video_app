<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $password_encoder)
    {
        $this->password_encoder = $password_encoder;
    }


    /**
     * @dataProvider getData
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $userData) {
             $user = new User();
             $user->setName($userData['name']);
             $user->setLastName($userData['last_name']);
             $user->setEmail($userData['email']);
             $user->setRoles($userData['roles']);
             $user->setPassword($this->password_encoder->encodePassword($user, 'password'));
             $manager->persist($user);
        }

        $manager->flush();
    }

    public function getData(): array
    {
        return [
            ['name'=> 'admin1', 'last_name'=> 'LstName', 'email'=> 'admin1@here.com', 'roles'=> ['ROLE_ADMIN']],
            ['name'=> 'user1', 'last_name'=> 'LstName', 'email'=> 'user1@here.com', 'roles'=> ['ROLE_USER']],
            ['name'=> 'user2', 'last_name'=> 'LstName', 'email'=> 'user2@here.com', 'roles'=> ['ROLE_USER']]
        ];
    }
}
