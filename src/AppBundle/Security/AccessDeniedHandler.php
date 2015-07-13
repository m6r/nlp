<?php

namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    /**
     * @var AuthrizationCHeckerInterface
     */
    private $security;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    public function __construct(AuthorizationCheckerInterface $authorization, UrlGeneratorInterface $router)
    {
        $this->authorization = $authorization;
        $this->router = $router;
    }

    /**
     * @inheritDoc
     */
    public function handle(Request $request, AccessDeniedException $exception)
    {
        if (!$this->authorization->isGranted('IS_PROFILE_LOCKED')) {
            return new RedirectResponse($this->router->generate('validate_profile'));
        }

        if ($this->authorization->isGranted('ROLE_PHONE_NOT_CONFIRMED')) {
            return new RedirectResponse($this->router->generate('validate_phone'));
        }
    }
}
