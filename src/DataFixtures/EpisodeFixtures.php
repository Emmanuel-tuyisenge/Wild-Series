<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 40; $i++) {
            $episode = new Episode();
            $faker  =  Faker\Factory::create('en_US');
            $episode->setNumber($faker->randomDigitNotNull)
                ->setTitle($faker->sentence)
                ->setSynopsis($faker->text)
                ->setSeason($this->getReference('season_' . rand(0, 9)));

            $slug = $this->slugify->generate($episode->getTitle());
            $episode->setSlug($slug);

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
