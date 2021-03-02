<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     * @param PostRepository $postRepository
     * @param $paginator
     * @param $request
     * @return Response
     */
    public function index(PostRepository $postRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $data = $this->getDoctrine()->getRepository(Post::class)->findBy([], ['created_at' => 'DESC']);

        $posts = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Set the connected member
            $post->setAuthor($this->getUser());

            // Set the creation datetime of the post
            $post->setCreatedAt(new \DateTime());

            // Set number of views to 1 when creating post
            $post->setViews('1');

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="post_show", methods={"GET"})
     * @param Post $post
     * @return Response
     */
    public function show(Post $post): Response
    {
        // Views: +1 for each visit
        $read = $post->getViews() + 1;
        $post->setViews($read);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($post);
        $entityManager->flush();

        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}
