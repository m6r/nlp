<?php

namespace VoteEquipeAnimationBundle\Poll;

use AppBundle\Entity\User;
use AppBundle\Entity\Poll\Election;
use AppBundle\Entity\Poll\AbstractPoll;
use AppBundle\Poll\ElectionRuleInterface;
use Doctrine\ORM\EntityManagerInterface;

class ElectionRule implements ElectionRuleInterface
{
    /**
     * @var Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * Constructor
     * @param Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @inheritdoc
     */
    public function getValidCriterias()
    {
        return array('Équipe d\'animation' => array(
            'default',
        ));
    }

    public function hasGenderParity()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function isAllowedToCandidate(User $user, Election $election)
    {
        return !$this->em->createQuery('
            SELECT candidacy
            FROM AppBundle:Poll\Candidacy candidacy
            JOIN candidacy.election election
            WHERE election.group = "Équipe d\'animation"
            AND candidacy.user = :user
        ')
            ->setParameter('user', $user->getId())
            ->getResult()
        ;
    }

    /**
     * @inheritdoc
     */
    public function isAllowedToVote(User $user, AbstractPoll $election)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getCandidateCriterias(User $user)
    {
        $isAllowed = !$this->em->createQuery('
            SELECT candidacy
            FROM AppBundle:Poll\Candidacy candidacy
            JOIN candidacy.election election
            WHERE election.group = "Équipe d\'animation"
            AND candidacy.user = :user
        ')
            ->setParameter('user', $user->getId())
            ->getResult()
        ;

        return $isAllowed ? $this->getValidCriterias() : array();
    }

    /**
     * @inheritdoc
     */
    public function getVoteCriterias(User $user)
    {
        return $this->getValidCriterias();
    }

    /**
     * @inheritdoc
     */
    public function getVoteNumber(User $user, Election $election)
    {
        return $this->getWinnersNumber($election);
    }

    /**
     * @inheritdoc
     */
    public function getWinnersNumber(Election $election)
    {
        return 2;
    }
}
