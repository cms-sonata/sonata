<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", defaults={"page": "1", "_format"="html"}, methods={"GET"}, name="news_index")
     * @Route("/news/rss.xml", defaults={"page": "1", "_format"="xml"}, methods={"GET"}, name="news_rss")
     * @Route("/news/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods={"GET"}, name="news_index_paginated")
     * @Cache(smaxage="10")
     */
    public function index(Request $request, int $page, string $_format, NewsRepository $news_repo)
    {
        $news = $news_repo->findAll();

        return $this->render('news/index.html.twig', [
            'news' => $news,
        ]);
    }
}
