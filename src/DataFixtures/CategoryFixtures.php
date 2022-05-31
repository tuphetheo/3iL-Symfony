<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES_NAMES = [
        'Sports',
        'Movies',
        'Games',
        'Music',
        'Books',
    ];

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::CATEGORIES_NAMES); $i++) {
            $category = new Category();
            $category->setName(self::CATEGORIES_NAMES[$i]);
            $manager->persist($category);
            $this->addReference(self::CATEGORIES_NAMES[$i], $category);
        }

        $manager->flush();
    }
}
