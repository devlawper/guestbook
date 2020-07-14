<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Comment;
use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AppFixtures extends Fixture
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager)
    {
        $paris = new Conference();
        $paris
            ->setCity('Paris')
            ->setYear('2019')
            ->setIsInternational(true)
        ;
        $manager->persist($paris);

        $lille = new Conference();
        $lille
            ->setCity('Lille')
            ->setYear('2020')
            ->setIsInternational(false)
        ;
        $manager->persist($lille);

        $comment1 = new Comment();
        $comment1
            ->setConference($paris)
            ->setAuthor('Laurent')
            ->setEmail('contact@devlawper.com')
            ->setText('This was a great conference.')
            ->setState('published')
        ;
        $manager->persist($comment1);

        $comment2 = new Comment();
        $comment2
            ->setConference($paris)
            ->setAuthor('Paul')
            ->setEmail('paul@devlawper.com')
            ->setText('I think this one is going to be moderated.')
        ;
        $manager->persist($comment2);

        $admin = new Admin();
        $admin
            ->setRoles(['ROLE_ADMIN'])
            ->setUsername('admin')
            ->setPassword($this->encoderFactory->getEncoder(Admin::class)->encodePassword('admin', null))
        ;
        $manager->persist($admin);

        $manager->flush();
    }
}
