<?php

namespace AppBundle\Listener;

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

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_CONFIRM => 'onRegistrationConfirm',
            //SecurityEvents::INTERACTIVE_LOGIN => 'onLogin'
        );
    }

    public function onRegistrationConfirm(GetResponseUserEvent $event)
    {
        $url = $this->router->generate('phone_send_code');

        $event->setResponse(new RedirectResponse($url));
    }

    public function onLogin(InteractiveLoginEvent $event)
    {
        $token = $event->getAuthenticationToken();

        $user = $token->getUser();
        $user->setLastIP($event->getRequest()->getClientIp());

        if (!$user->isPhoneConfirmed()) {
            $url = $this->router->generate('phone_confirm');

            return new RedirectResponse($url);
        }
    }
}
