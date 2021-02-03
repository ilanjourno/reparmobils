<?php

namespace App\Controller;

use App\Entity\NewsletterEmails;
use App\Form\NewsletterEmailType;
use App\Services\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class NewsletterEmailsController extends AbstractController
{
    /**
     * @Route("/newsletter/emails", name="newsletter_emails")
     */
    public function index(): Response
    {
        return $this->render('newsletter_emails/index.html.twig', [
            'controller_name' => 'NewsletterEmailsController',
        ]);
    }

    /**
     * @Route("/newsletter/email/new", name="newsletter_email_new")
     */
    public function new(Request $request, Mailer $mailer): Response
    {
        $email = new NewsletterEmails();
        $form = $this->createForm(NewsletterEmailType::class, $email);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($email);
            $entityManager->flush();
            // $mailer->sendMail([$contact->getEmail()], "Votre demande de contact sur notre site !", "contact/emails/client.html.twig");
            $this->addFlash('success', "Merci ! Vous êtes bien inscrit à notre newsletter !");
        }

        return $this->render('_newsletter_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
