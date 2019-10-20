<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminNewsController extends AbstractController
{
    /**
     * @Route("/admin/news", name="admin_news")
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

}
