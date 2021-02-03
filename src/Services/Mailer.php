<?php

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class Mailer {

    private $mailerInterface;

    public function __construct(MailerInterface $mailer){
        $this->mailerInterface = $mailer;
    }

    public function sendMail(array $users, string $subject, string $template, ?array $context = []){
        
        $emails = array();
        for ($i=0; $i < count($users) ; $i++) { 
            $emails[] = new Address($users[$i]->getEmail(), $users[$i]->getUsername());
        }
        
        $email = (new TemplatedEmail())
        ->from(new Address('contact@reparmobils.fr', 'Repar Mobils Dignois'))
        ->to(...$emails)
        ->priority(Email::PRIORITY_HIGH)
        ->subject($subject)
        ->context($context)
        ->htmlTemplate($template);

        $email->getHeaders()->addTextHeader('X-Auto-Response-Suppress', 'OOF, DR, RN, NRN, AutoReply');

        $this->mailerInterface->send($email);
    } 

}