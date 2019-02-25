<?php


namespace MA\PlatformBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use MA\PlatformBundle\Entity\Application;
use MA\PlatformBundle\Entity\ApplicationMailer;

class ApplicationCreationListener  
{
    /*
    * @var ApplicationMailer
    */
    private $applicationMailer;

    public function _construct(\Swift_Mailler $mailer)
    {
        $this->applicationMailer = $applicationMailer;  
    }

    public function postPersist(LifecycleEventArgs $arg)
    {
    //    $entity = $arg->getObject();

    //    if (!$entity instanceof Application) {
    //        return;
    //    }
    //    $this->applicationMailer->sendNewNotification($entity);
    }
}
