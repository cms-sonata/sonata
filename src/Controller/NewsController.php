<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Michelf\MarkdownInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", defaults={"_format"="html"}, methods={"GET"}, name="news_index")
     * @Cache(smaxage="10")
     */
    public function index(Request $request, string $_format, NewsRepository $newsRepo, PaginatorInterface $paginator)
    {
        $queryBuilder = $newsRepo->getPublishedQueryBuilder();

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1)
        );

        return $this->render('news/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/news/{slug}", name="news_show")
     */
    public function show(News $news)
    {
        return $this->render('news/show.html.twig', [
            'news_post' => $news
        ]);
    }
}
