<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\AlertBootstrapInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactController
 * @package App\Controller
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function index(Request $request, MailerInterface $mailer, AlertBootstrapInterface $alert): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
             $contactFormData = $form->getData();

             $message = (new Email())
                ->from($contactFormData['email'])
                ->to('contact@pengolincoin.xyz')
                ->subject('Message from blog.pengolincoin.xyz')
                ->html('From : ' . $contactFormData['name'] . '<br>' . 'Email: ' . $contactFormData['email'] . '<br>' . $contactFormData['message'], 'text/plain');
            $mailer->send($message);

            $alert->success('Success! Your message has been sent!');

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'our_form' => $form->createView()
        ]);
    }
}
