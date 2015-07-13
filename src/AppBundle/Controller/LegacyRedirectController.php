<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LegacyRedirectController extends Controller
{
    /**
     * @Route("/legacy", name="back_to_legacy")
     */
    public function backToLegacyAction()
    {
        $baseUrl = $this->container->getParameter('legacy_base_url');

        return $this->redirect($baseUrl.'/');
    }

    /**
     * @Route("/submit", name="submit")
     */
    public function submitAction()
    {
        $baseUrl = $this->container->getParameter('legacy_base_url');

        return $this->redirect($baseUrl.'/submit.php');
    }

    /**
     * @Route("/groups", name="groups")
     */
    public function groupsAction()
    {
        $baseUrl = $this->container->getParameter('legacy_base_url');

        return $this->redirect($baseUrl.'/groups.php');
    }

    /**
     * @Route("/profile/{username}", name="profile")
     */
    public function profileAction(User $user)
    {
        $baseUrl = $this->container->getParameter('legacy_base_url');

        return $this->redirect($baseUrl.'/user.php?login='.$user->getUsername());
    }

    /**
     * @Route("/login/forgot-password", name="login_forgot_password")
     */
    public function loginForgotPasswordAction()
    {
        $baseUrl = $this->container->getParameter('legacy_base_url');

        return $this->redirect($baseUrl.'/login.php');
    }
}
