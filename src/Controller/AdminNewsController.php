<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsFormType;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/admin/news/create", name="admin_news_create")
     * @IsGranted("ROLE_ADMIN_NEWS")
     */
    public function create(EntityManagerInterface $entityManager, Request $request)
    {
        $form = $this->createForm(NewsFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var News $news */
            $news = $form->getData();

            $entityManager->persist($news);
            $entityManager->flush();

            $this->addFlash('success', 'News created!');

            return $this->redirectToRoute('admin_news');
        }

        return $this->render('admin_news/create.html.twig', [
            'news_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/news/{id}/edit", name="admin_news_edit")
     * @IsGranted("NEWS_EDIT", subject="news")
     */
    public function edit(News $news, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(NewsFormType::class, $news, [
            'include_published_at' => true
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($news);
            $entityManager->flush();

            $this->addFlash('success', 'News updated!');

            return $this->redirectToRoute('admin_news_edit', ['id' => $news->getId()]);
        }

        return $this->render('admin_news/edit.html.twig', [
            'news_form' => $form->createView()
        ]);
    }
}
