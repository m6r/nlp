<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Poll\Candidacy;
use AppBundle\Entity\Poll\Election;
use AppBundle\Entity\Poll\ElectionVote;
use AppBundle\Entity\Poll\Poll;
use AppBundle\Entity\Poll\PollVote;
use AppBundle\Form\Type\CandidacyType;
use AppBundle\Form\Type\ElectionVoteType;
use AppBundle\Form\Type\PollVoteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route("/polls")
 * @Security("is_granted('ROLE_USER') && is_granted('IS_PROFILE_LOCKED') && is_granted('ROLE_VOTER')")
 */
class PollController extends Controller
{
    /**
     * @Route("/", name="polls")
     */
    public function listPollsAction()
    {
        $security = $this->get('security.authorization_checker');
        $em = $this->getDoctrine()->getManager();

        $elections = $em->getRepository('AppBundle:Poll\Election')->findAllCurrent();
        $userElections = array();
        $otherElections = array();
        foreach ($elections as $election) {
            $grantVote = $security->isGranted('ELECTION_VOTE', $election);
            $grantCandidate = $security->isGranted('ELECTION_CANDIDATE', $election);
            if ($grantVote || $grantCandidate) {
                $userElections[] = $election;
            } else {
                $otherElections[] = $election;
            }
        }

        $pastElections = $em->getRepository('AppBundle:Poll\Election')->findAllPast();

        $currentPolls = $em->getRepository('AppBundle:Poll\Poll')->findAllCurrent();

        return $this->render('poll/list.html.twig', array(
            'userElections' => $userElections,
            'otherElections' => $otherElections,
            'pastElections' => $pastElections,
            'userPolls' => $currentPolls,
        ));
    }

    /**
     * @Route("/election/{id}/show", name="election_show", requirements={"id": "\d+"})
     */
    public function electionShowAction(Election $election)
    {
        $voteNumber = $this->get('app.election_ruler')->getVoteNumber($this->getUser(), $election);

        return $this->render('poll/election_show.html.twig', array(
            'election' => $election,
            'voteNumber' => $voteNumber,
        ));
    }

    /**
     * @Route("/election/{id}/candidate", name="election_candidate", requirements={"id": "\d+"})
     * @Security("is_granted('ELECTION_CANDIDATE', election)")
     */
    public function electionDoCandidateAction(Election $election, Request $request)
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
     * @Security("is_granted('ELECTION_VOTE', election)")
     */
    public function electionDoVoteAction(Election $election, Request $request)
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
     * @Security("is_granted('ELECTION_VOTE', election)")
     */
    public function electionVoteConfirmAction(Election $election, Request $request)
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

    /**
     * @Route("/{id}/vote", name="poll_vote", requirements={"id": "\d+"})
     * @Security("is_granted('POLL_VOTE', poll)")
     */
    public function pollVoteAction(Poll $poll, Request $request)
    {
        $vote = new PollVote($poll, $request->getClientIp(), $this->getUser());

        $form = $this->createForm(new PollVoteType($this->get('markdown.parser')), $vote);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $poll->addVoter($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($poll);
            $em->persist($vote);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('flash.vote.sent', array(), 'flash')
            );

            return $this->redirect($this->generateUrl('polls'));
        }

        return $this->render('poll/poll_vote.html.twig', array(
            'form' => $form->createView(),
            'poll' => $poll,
        ));
    }
}
