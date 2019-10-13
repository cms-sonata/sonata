<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Common\Persistence\ObjectManager;

class NewsFixtures extends AbstractFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'news', function($i) {
            $news = new News();
            $news
                ->setTitle($this->faker->text)
                ->setContent($this->faker->realText());
            // publish most articles
            if ($this->faker->boolean(70)) {
                $news->setPublishedAt($this->faker->dateTimeBetween('-100 days', 'today'));
            }

            return $news;
        });
        $manager->flush();
    }
}
