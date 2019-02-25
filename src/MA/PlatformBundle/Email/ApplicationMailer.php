<?php


namespace MA\PlatformBundle\Email;
use MA\PlatformBundle\Entity\Application;

class ApplicationMailer
{
    /*
    * @var \Swift_Mailer
    */
    private $mailer;

    public function _construct(\Swift_Mailler $mailer)
    {
        $this->mailer = $mailer;  
    }

    public function sendNewNotification(Application $application)
    {


        // $transport = Swift_SmtpTransport::newInstance(sfConfig::get('sf_smtp_host'), sfConfig::get('sf_smtp_port'))
        //     ->setUsername(sfConfig::get('sf_smtp_user'))
        //     ->setPassword(sfConfig::get('sf_smtp_pass'))
        // ;
        // $mailer = SwiftMailer::newInstance($transport);
        //     $message = Swift_Message::newInstance('Subject')
        // ->setFrom(array('john@doe.com' => 'John Doe'))
        // ->setTo(array('receiver@domain.com' => 'Receiver Name'))
        // ->setBody($this->getPartial('mail/registerNewText', $members))
        // ->addPart($this->getPartial('mail/registerNewHtml', $members), 'text/html');
     
    // $result = $mailer->send($message);

        // $message = new \Swift_Mailer('Nouvelle candidature', ' Bonjour, vous avez reçu une nouvelle candidature. Félicitation ! Vous etes bien chanceux !!');
        
        // creation du message: objet et corps de l'email

        // $message->addTo($application->getAdvert()->getAuthor())->addFrom('admin@street4fit.com');

    // Onsuppose que getAuthor contient l'email de la personne qui a crée l'application! j'envoi le message a cette adresse mail (TO -> destinateur) et j'indique l'adresse de mon administrateur (FROM) pour indiquer l'emetteur du mail

        // $message->addTo('assa.traore@lepoles.com')->addFrom('admin@street4fit.com');
        
    }
}
