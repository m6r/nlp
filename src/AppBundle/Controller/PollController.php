<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Poll\Candidacy;
use AppBundle\Entity\Poll\Election;
use AppBundle\Entity\Poll\ElectionVote;
use AppBundle\Form\Type\CandidacyType;
use AppBundle\Form\Type\ElectionVoteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route("/polls")
 */
class PollController extends Controller
{
    /**
     * @Route("/", name="polls")
     */
    public function listPollsAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_PROFILE_LOCKED')) {
            return $this->redirect($this->generateUrl('profile_validate'));
        }

        $criterias = array_merge_recursive(
            $this->get('app.election_ruler')->getCandidateCriterias($this->getUser()),
            $this->get('app.election_ruler')->getVoteCriterias($this->getUser())
        );

        $em = $this->getDoctrine()->getManager();

        $userElections = array();
        foreach ($criterias as $groupName => $criteriaGroup) {
            $result = $em->createQuery(
                'SELECT e
                FROM AppBundle:Poll\Election e
                WHERE e.openCandidacyDate < CURRENT_TIMESTAMP()
                AND e.closeDate > CURRENT_TIMESTAMP()
                AND e.group = :groupName
                AND e.criteria IN(:criteriaGroup)'
            )->setParameter('groupName', $groupName)
                ->setParameter('criteriaGroup', $criteriaGroup)
                ->getResult();

            if ($result) {
                $userElections = array_merge($userElections, $result);
            }
        }

        $otherPolls = $em->getRepository('AppBundle:Poll\Poll')->findAllCurrent();
        $elections = $em->getRepository('AppBundle:Poll\Election')->findAllCurrent();
        $otherElections = array_udiff($elections, $userElections, function ($a, $b) {
            return $a->getId() === $b->getId();
        });

        return $this->render('poll/list.html.twig', array(
            'userElections' => $userElections,
            'otherPolls' => $otherPolls,
            'otherElections' => $otherElections,
        ));
    }

    /**
     * @Route("/election/{id}/show", name="election_show", requirements={"id": "\d+"})
     * @Security("is_granted('IS_PROFILE_LOCKED')")
     */
    public function showElectionAction(Election $election)
    {
        $voteNumber = $this->get('app.election_ruler')->getVoteNumber($this->getUser(), $election);

        return $this->render('poll/election_show.html.twig', array(
            'election' => $election,
            'voteNumber' => $voteNumber,
        ));
    }

    /**
     * @Route("/election/{id}/candidate", name="election_candidate", requirements={"id": "\d+"})
     * @Security("is_granted('IS_PROFILE_LOCKED') && is_granted('ELECTION_CANDIDATE', election)")
     */
    public function doCandidateAction(Election $election, Request $request)
    {
        $user = $this->getUser();
        $candidacy = new Candidacy($election);
        $candidacy->setUser($user);

        $form = $this->createForm(new CandidacyType(), $candidacy);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($candidacy);
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('flash.candidacy.sent', array(), 'flash')
            );

            return $this->redirect($this->generateUrl('polls'));
        }

        return $this->render('poll/election_candidate.html.twig', array(
            'election' => $election,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/election/{id}/vote", name="election_vote", requirements={"id": "\d+"})
     * @Security("is_granted('IS_PROFILE_LOCKED') && is_granted('ELECTION_VOTE', election)")
     */
    public function doVoteAction(Election $election, Request $request)
    {
        $voteNumber = $this->get('app.election_ruler')->getVoteNumber($this->getUser(), $election);
        $parity = $this->get('app.election_ruler')->hasGenderParity($election);

        $vote = new ElectionVote($election, $request->getClientIp(), $this->getUser());
        // Populate $vote with previous choices if user has cancelled from confirm page for example.
        if ('GET' === $request->getMethod() && ($voteRequest = $this->get('session')->get('voteToConfirm'))) {
            $previousForm = $this->createForm(new ElectionVoteType(), $vote, array(
                'candidacies' => $election->getCandidacies(),
                'voteNumber' => $voteNumber,
            ));
            $previousForm->handleRequest($voteRequest);
        }

        $form = $this->createForm(new ElectionVoteType(), $vote, array(
            'candidacies' => $election->getCandidacies(),
            'voteNumber' => $voteNumber,
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('session')->set('voteToConfirm', $request);

            return $this->redirect($this->generateUrl('election_vote_confirm', array('id' => $election->getId())));
        }

        return $this->render('poll/election_vote.html.twig', array(
            'form' => $form->createView(),
            'election' => $election,
            'voteNumber' => $voteNumber,
            'parity' => $parity,
        ));
    }

    /**
     * @Route("/election/{id}/vote/confirm", name="election_vote_confirm", requirements={"id": "\d+"})
     * @Security("is_granted('IS_PROFILE_LOCKED') && is_granted('ELECTION_VOTE', election)")
     */
    public function voteConfirmAction(Election $election, Request $request)
    {
        if (!($voteRequest = $this->get('session')->get('voteToConfirm'))) {
            return $this->redirect($this->generateUrl('election_vote', array('id' => $election->getId())));
        }

        $voteNumber = $this->get('app.election_ruler')->getVoteNumber($this->getUser(), $election);

        $vote = new ElectionVote($election, $request->getClientIp(), $this->getUser());
        $voteForm = $this->createForm(new ElectionVoteType(), $vote, array(
            'candidacies' => $election->getCandidacies(),
            'voteNumber' => $voteNumber,
        ));
        $voteForm->handleRequest($voteRequest);

        if (!$voteForm->isValid()) {
            return $this->redirect($this->generateUrl('election_vote', array('id' => $election->getId())));
        }

        $confirmationForm = $this->createFormBuilder(array('confirmation' => false))
            ->add('confirmation', 'checkbox', array(
                'mapped' => false,
                'constraints' => array(new Assert\NotBlank()),
            ))
            ->getForm();

        $confirmationForm->handleRequest($request);

        if ($confirmationForm->isSubmitted() && $confirmationForm->isValid()) {
            $election->addVoter($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($election);
            $em->persist($vote);
            $em->flush();

            $this->get('session')->remove('voteToConfirm');
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('flash.vote.sent', array(), 'flash')
            );

            return $this->redirect($this->generateUrl('polls'));
        }

        return $this->render('poll/election_vote_confirm.html.twig', array(
            'form' => $confirmationForm->createView(),
            'election' => $election,
            'voteNumber' => $voteNumber,
            'vote' => $vote,
        ));
    }
}
