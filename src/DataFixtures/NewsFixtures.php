<?php

namespace App\DataFixtures;

use App\Entity\News;
use App\Entity\Tag;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class NewsFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(20, 'news', function($i) {

            $news = new News();
            $news
                ->setTitle($this->faker->text(100))
                ->setContent($this->faker->text(400))
            ;

            $news->setAuthor($this->getRandomReference('main_users'));
            if ($this->faker->boolean(70)) {
                $news->setPublishedAt($this->faker->dateTimeBetween('-100 days', 'today'));
            }

            $tags = $this->getRandomReferences('tags', $this->faker->numberBetween(0, 5));

            foreach ($tags as $tag) {
                $news->addTag($tag);
            }

            return $news;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixture::class,
            TagFixture::class
        ];
    }
}
