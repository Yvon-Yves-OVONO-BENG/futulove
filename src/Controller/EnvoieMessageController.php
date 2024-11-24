<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnvoieMessageController extends AbstractController
{
    #[Route('/envoie-message', name: 'envoie_message')]
    public function envoieMessage(Request $request): Response
    {
        /*
        name
        email
        phone
        subject
        message
        */
        // Only process POST reqeusts.
        dd($request);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the form fields and remove whitespace.
            $name = strip_tags(trim($_POST["name"]));
            // $name = str_replace(array("\r","\n"),array(" "," "),$name);
            $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
            $phone = trim($_POST["phone"]);
            $subject = trim($_POST["subject"]);
            $message = trim($_POST["message"]);
            $select = trim($_POST["select"]);

            // Check that data was sent to the mailer.
            // if ( empty($name) OR empty($subject) OR empty($phone) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //     // Set a 400 (bad request) response code and exit.
            //     http_response_code(400);
            //     echo "Please complete the form and try again.";
            //     exit;
            // }

            // Set the recipient email address.
            // FIXME: Update this to your desired email address.
            $recipient = "info@example.com";

            // Build the email content.
            $email_content = "Nom complet : $name\n";
            $email_content = "Téléphone : $phone\n";
            $email_content .= "Email : $email\n\n";
            $email_content .= "Sujet : $subject\n\n";
            $email_content .= "Message :\n$message\n";

            // Build the email headers.
            $email_headers = "From: $name <$email>";

            // Send the email.
            if (mail($recipient, $subject, $email_content, $email_headers)) {
                // Set a 200 (okay) response code.
                http_response_code(200);
                echo "Merci! Votre message a été envoyé.";
            } else {
                // Set a 500 (internal server error) response code.
                http_response_code(500);
                echo "Oops! Quelque chose s'est mal passé et nous n'avons pas pu envoyer votre message.";
            }

        } else {
            // Not a POST request, set a 403 (forbidden) response code.
            http_response_code(403);
            echo "Il y a eu un problème avec votre soumission, veuillez réessayer.";
        }

    }
}
