<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user->setNom('Bureth')->setPrenom(prenom: 'Joana');
        $user->setEmail(email: 'brth.joana@gmail.com');
        $user->setRoles(['ROLE_USER']);

        $encodedUser = $this->encoder->hashPassword($user, '123');
        $user->setPassword($encodedUser);

        # ----------

        $admin = new User();

        $admin->setNom(nom: 'Bureth')->setPrenom(prenom: 'Joana');
        $admin->setEmail(email: 'admin@gmail.com');
        $admin->setRoles(roles: ['ROLE_ADMIN']);

        $encodedAdmin = $this->encoder->hashPassword(user: $admin, plainPassword: '123');
        $admin->setPassword(password: $encodedAdmin);

        # ----------

        $employee = new User();

        $employee->setNom(nom: 'Doe')->setPrenom(prenom: 'John');
        $employee->setEmail(email: 'john.doe@gmail.com');
        $employee->setRoles(roles: ['ROLE_EMPLOYEE']);

        $encodedEmployee = $this->encoder->hashPassword(user: $employee, plainPassword: '123');
        $employee->setPassword(password: $encodedEmployee);

        # ----------

        $manager->persist($user);
        $manager->persist($admin);
        $manager->persist($employee);

        $manager->flush();
    }
}
