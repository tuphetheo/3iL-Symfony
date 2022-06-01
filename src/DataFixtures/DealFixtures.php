<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Deal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DealFixtures extends Fixture
{
    public const DEAL_NAMES = [
        'Ball',
        'Shoes',
        'Avengers Endgame',
        'No Time to Die',
        'Animal Crossing New Horizons',
        'Splatoon 3',
        'I want to break free',
        'Enemy',
        'Heartstopper',
        'Hunger Games'
    ];

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::DEAL_NAMES); $i++) {
            $deal = new Deal();
            $deal->setName(self::DEAL_NAMES[$i]);
            $deal->setDescription('Lorem Ipsum');
            $deal->setPrice(rand(1, 100));
            $deal->setEnabled(true);

            /**
             * @var Category $category
             */
            $category = $this->getReference(CategoryFixtures::CATEGORIES_NAMES[round($i / 2, 0, PHP_ROUND_HALF_DOWN)]);
            $deal->addCategory($category);
            $manager->persist($deal);
        }

        $manager->flush();
    }
}
