<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminNewsController extends AbstractController
{
    /**
     * @Route("/admin/news", name="admin_news")
     * @IsGranted("ROLE_ADMIN_NEWS")
     */
    public function index(NewsRepository $newsRepository, Request $request, PaginatorInterface $paginator)
    {
        $searchPhrase = $request->query->get('q');
        $queryBuilder = $newsRepository->getWithSearchQueryBuilder($searchPhrase);

        $paginaton = $paginator->paginate(
            $queryBuilder, $request->query->getInt('page', 1)
        );

        return $this->render('admin_news/index.html.twig', [
            'pagination' => $paginaton,
            'searchPhrase' => $searchPhrase
        ]);
    }

    /**
     * @Route("/admin/news/{id}/edit")
     * @IsGranted("NEWS_EDIT", subject="news")
     */
    public function edit(News $news)
    {
        dd($news);


    }

}
