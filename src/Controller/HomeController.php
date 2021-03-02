<?php

namespace App\Controller;

use App\Entity\Post;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $data = $this->getDoctrine()->getRepository(Post::class)->findBy([], ['created_at' => 'desc']);

        $posts = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('home/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
