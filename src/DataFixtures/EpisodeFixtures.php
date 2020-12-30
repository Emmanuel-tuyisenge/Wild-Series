<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 40; $i++) {
            $episode = new Episode();
            $faker  =  Faker\Factory::create('en_US');
            $episode->setNumber($faker->randomDigitNotNull);
            $episode->setTitle($faker->sentence);
            $episode->setSynopsis($faker->text);
            $episode->setSeason($this->getReference('season_' . rand(0, 9)));
            $manager->persist($episode);
            $this->addReference('episode_' . $i, $episode);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}
