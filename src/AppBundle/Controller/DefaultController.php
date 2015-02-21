<?php

namespace AppBundle\Controller;

use AppBundle\Form\VoterProfileValidationType;
use AppBundle\Entity\Poll\ProfileLock;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $this->container->get('security.context')->setToken(null);

        return $this->redirect($this->generateUrl('polls'));
    }

    /**
     * @Route("/profile/validate", name="profile_validate")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function profileValidateAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_PROFILE_LOCKED')) {
            return $this->redirect($this->generateUrl('index'));
        }

        $user = $user = $this->getUser();
        $form = $this->createForm(new VoterProfileValidationType(), $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $profileLock = new ProfileLock($user);
            $em->persist($profileLock);
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('polls'));
        }

        return $this->render('default/profile_validate.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
