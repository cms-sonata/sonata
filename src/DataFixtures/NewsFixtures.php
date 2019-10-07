<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Common\Persistence\ObjectManager;

class NewsFixtures extends AbstractFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(News::class, 10, function(News $news) {
            $news
                ->setTitle($this->faker->text)
                ->setContent($this->faker->realText());
            // publish most articles
            if ($this->faker->boolean(70)) {
                $news->setPublishedAt($this->faker->dateTimeBetween('-100 days', 'today'));
            }
        });
        $manager->flush();
    }
}
