<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\SearchPostType;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search", methods={"GET", "POST"})
     * @param Request $request
     * @param PostRepository $repo
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, PostRepository $repo, PaginatorInterface $paginator): Response
    {
        $searchForm = $this->createForm(SearchPostType::class);
        $searchForm->handleRequest($request);

        $donnees = $repo->findPosts();

        if ($searchForm->isSubmitted() && $searchForm->isValid())
        {
            $title = $searchForm->getData()->getTitle();
            $donnees = $repo->search($title);
        }

        // Paginate the results of the query
        $pagination = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            50
        );

        return $this->render('search/index.html.twig', [
            'pagination' => $pagination,
            'searchForm' => $searchForm->createView()
        ]);
    }
}
