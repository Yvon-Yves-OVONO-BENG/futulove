<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        if ($request->request->has('envoyer')) 
        {
            $nom = $request->request->get('nom');
            $email = $request->request->get('email');
            $message = $request->request->get('message');

            ///envoie
            $email = (new Email())
            ->from($email)
            ->to('admi@monamesoeur.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Demande de contact')
            ->text($message)
            // ->html('<p>See Twig integration for better HTML integration!</p>')
            ;

            $mailer->send($email);

        }

        return $this->render('contact/contact.html.twig', [
            
        ]);
    }
}
