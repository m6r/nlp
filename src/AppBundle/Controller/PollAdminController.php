<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Poll\Poll;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin/polls")
 */
class PollAdminController extends Controller
{
    /**
     * @Route("/list", name="admin_polls")
     */
    public function listPollAction(Request $req)
    {
        $em = $this->getDoctrine()->getManager();
        $polls = $em->getRepository('AppBundle:Poll\Election')->findAll();

        return $this->render('admin/poll/list.html.twig', array(
            'polls' => $polls,
        ));
    }
}
