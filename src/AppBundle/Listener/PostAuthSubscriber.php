<?php

namespace AppBundle\Listener;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class PostAuthSubscriber implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(UrlGeneratorInterface $router, EntityManager $em)
    {
        $this->router = $router;
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_CONFIRM => 'onRegistrationConfirm',
            SecurityEvents::INTERACTIVE_LOGIN => 'onLogin'
        );
    }

    public function onRegistrationConfirm(GetResponseUserEvent $event)
    {
        $user = $event->getUser();
        $user->setIP($event->getRequest()->getClientIp());
        $this->em->persist($user);
        $this->em->flush();

        $url = $this->router->generate('validate_phone');
        $event->setResponse(new RedirectResponse($url));
    }

    public function onLogin(InteractiveLoginEvent $event)
    {
        $token = $event->getAuthenticationToken();
        $user = $token->getUser();
        $user->setLastIP($event->getRequest()->getClientIp());
        $user->setLastLogin(new \DateTime());
        $this->em->persist($user);
        $this->em->flush();
    }
}
