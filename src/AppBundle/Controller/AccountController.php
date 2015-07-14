<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\VoterProfileValidationType;
use libphonenumber\PhoneNumberFormat;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Util\SecureRandom;
use Symfony\Component\Security\Core\Util\StringUtils;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class AccountController extends Controller
{
    /**
     * @Route("/account/validate", name="validate_profile")
     * @Security("not is_granted('IS_PROFILE_LOCKED')")
     */
    public function profileValidateAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(new VoterProfileValidationType(), $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setProfileFrozen(true);
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('polls'));
        }

        return $this->render('account/validate_profile.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/account/edit-phone", name="edit_phone")
     * @Security("is_granted('IS_PROFILE_LOCKED') and is_granted('ROLE_PHONE_NOT_CONFIRMED')")
     */
    public function editPhoneNumberAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createFormBuilder($user, array('validation_groups' => array('freeze')))
            ->add('phoneNumber', 'tel', array(
                'default_region' => 'FR',
                'format' => PhoneNumberFormat::NATIONAL,
                'label' => 'label.phoneNumber',
            ))
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('validate_phone'));
        }

        return $this->render('account/edit_phone.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/account/validate-phone", name="validate_phone")
     * @Security("is_granted('IS_PROFILE_LOCKED') and is_granted('ROLE_PHONE_NOT_CONFIRMED')")
     */
    public function validatePhoneAction(Request $request)
    {
        $user = $this->getUser();
        $data = array('code' => null);
        $form = $this->createFormBuilder($data)
            ->add('code', 'text')
            ->getForm();

        $sendCodeForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('phone_send_code'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $code = $form->get('code')->getData();
            dump($code);
            dump($user->getPhoneCode());

            if (StringUtils::equals($user->getPhoneCode(), $code)) {
                $user->setPhoneConfirmed(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirect($this->generateUrl('polls'));
            }

            $errMsg = $this->get('translator')->trans('error.invalid_code', array(), 'validators');
            $form->addError(new FormError($errMsg));
        }

        return $this->render('account/validate_phone.html.twig', array(
            'form' => $form->createView(),
            'sendCodeForm' => $sendCodeForm->createView(),
        ));
    }

    /**
     * @Route("/account/validate-phone/send-code", name="phone_send_code")
     */
    public function sendPhoneValidationCodeAction(Request $request)
    {
        $form = $this->createFormBuilder(array('delete' => null))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $this->getUser();
            $code = $this->generateCode();
            $user->setPhoneCode($code);
            $sms = $this->get('app.sms_sender');
            try {
                $phoneUtil = $this->get('libphonenumber.phone_number_util');
                $sms->send(
                    $phoneUtil->format($user->getPhoneNumber(), PhoneNumberFormat::E164),
                    $this->renderView('sms/validation.txt.twig', array('code' => $code))
                );
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add(
                    'error',
                    $this->get('translator')->trans('error.send.sms', array(), 'flash')
                );

                $this->get('logger')->error($e);

                return $this->redirectToRoute('validate_phone');
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('validate_phone');
        }
    }

    private function generateCode()
    {
        $generator = new SecureRandom();
        $random = '';

        for ($i = 0; $i < 6; $i++) {
            $random .= (ord($generator->nextBytes(1)) % 10);
        }

        return $random;
    }
}
