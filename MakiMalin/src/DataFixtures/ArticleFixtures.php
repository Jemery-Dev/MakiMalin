<?php

namespace App\DataFixtures;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture
{private $categorieArticleRepository;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setNom($faker->words(3, true));
            $article->setImage($faker->imageUrl());
            $article->setPrix($faker->randomFloat(2, 1, 1000));
            $article->setDescription($faker->paragraph());
            $manager->persist($article);
        }

        $manager->flush();
    }
}