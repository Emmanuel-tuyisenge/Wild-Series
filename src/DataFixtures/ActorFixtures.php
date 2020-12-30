<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = [
        'Andrew Lincoln',
        'Norman Reedus',
        'Lauren Cohan',
        'Danai Gurira',
    ];

    public function load(ObjectManager $manager)
    {
        foreach(self::ACTORS as $key => $actorName) {
            $actor = new Actor();
            $actor->setName($actorName);

            $manager->persist($actor);
            $this->addReference('actor_' . $key, $actor);
        }
        for ($i = 4; $i < 40; $i++) {
            $actor = new Actor();
            $faker  =  Faker\Factory::create('en_US');
            $actor->setName($faker->name)
                ->addProgram($this->getReference('program_' . rand(0,count(ProgramFixtures::PROGRAMS)-1)));
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}
