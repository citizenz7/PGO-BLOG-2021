<?php

namespace App\Controller;

use App\Form\Model\SearchPost;
use App\Form\SearchPostType;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchController
 * @package App\Controller
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search", methods={"GET"})
     * @param Request $request
     * @param PostRepository $repo
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, PostRepository $repo, PaginatorInterface $paginator): Response
    {
        $searchPost = new SearchPost();
        $form = $this->createForm(SearchPostType::class, $searchPost, [
            'action' => $this->generateUrl('search'),
            'method' => 'GET',
        ]);

        $form->handleRequest($request);

        $data = $repo->findPosts();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $repo->search($searchPost->getTitle());
        }

        // Paginate the results of the query
        $pagination = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('search/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView()
        ]);
    }
}
