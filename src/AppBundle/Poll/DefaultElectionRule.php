<?php

namespace AppBundle\Poll;

use AppBundle\Entity\User;
use AppBundle\Entity\Poll\Election;
use AppBundle\Entity\Poll\AbstractPoll;

class DefaultElectionRule implements ElectionRuleInterface
{
    /**
     * @inheritdoc
     */
    public function getValidCriterias()
    {
        return array('default' => array('gender_parity'));
    }

    /**
     * @inheritdoc
     */
    public function hasGenderParity()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function isAllowedToCandidate(User $user, Election $election)
    {
        return 'gender_parity' === $election->getCriteria();
    }

    /**
     * @inheritdoc
     */
    public function isAllowedToVote(User $user, AbstractPoll $election)
    {
        return 'gender_parity' === $election->getCriteria();
    }

    /**
     * @inheritdoc
     */
    public function getCandidateCriterias(User $user)
    {
        return $this->getValidCriterias();
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
