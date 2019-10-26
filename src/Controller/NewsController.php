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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", methods={"GET"}, name="news_index")
     * @Cache(smaxage="10")
     * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
     */
    public function index(Request $request, NewsRepository $newsRepo, PaginatorInterface $paginator)
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
     * @Route("/news/{slug}", methods={"GET"}, name="news_show")
     * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
     */
    public function show(News $news)
    {
        return $this->render('news/show.html.twig', [
            'news_post' => $news
        ]);
    }

    /**
     * @Route("/news/tag/{tag}", methods={"GET"}, name="news_tag")
     * @Cache(smaxage="10")
     * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
     */
    public function tag(string $tag, Request $request, NewsRepository $newsRepo, PaginatorInterface $paginator)
    {
        $queryBuilder = $newsRepo->getTaggedQueryBuilder($tag);

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1)
        );

        return $this->render('news/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
