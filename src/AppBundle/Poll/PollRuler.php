<?php

namespace AppBundle\Poll;

use AppBundle\Entity\User;
use AppBundle\Entity\Poll\Election;

class PollRuler
{
    /**
     * All the elections rules registered with the tag app.election_rule. We use
     * groups registered by election rules as key (so same ElectionRule can
     * be several times in the table if it manages several groups).
     *
     * @var array
     */
    private $electionRules;

    /**
     * Called by the compiler pass to add all tagged election rules.
     *
     * @param ElectionRuleInterface $electionRule
     */
    public function addElectionRule(ElectionRuleInterface $electionRule)
    {
        foreach ($electionRule->getValidCriterias() as $group => $criterias) {
            $this->electionRules[$group] = $electionRule;
        }
    }

    /**
     * Should return an array of arrays with groups in key and criteria ids
     * in values of each array like array('group1' => array('criteria1', 'criteria2')).
     *
     * @return array
     */
    public function getValidCriterias()
    {
        $criterias = array();

        foreach ($this->electionRules as $electionRule) {
            $newCriterias = $electionRule->getValidCriterias();
            $criterias = array_merge($criterias, $newCriterias);
        }

        return $criterias;
    }

    /**
     * Is the user allowed to candidate to an election.
     *
     * @param User     $user     The user we should check.
     * @param Election $election The election we are talking about.
     *
     * @return boolean
     */
    public function isAllowedToCandidate(User $user, Election $election)
    {
        return $this->electionRules[$election->getGroup()]
            ->isAllowedToCandidate($user, $election);
    }

    /**
     * Is the user allowed to vote in an election.
     *
     * @param User     $user     The user we should check.
     * @param Election $election The election we are talking about.
     *
     * @return boolean
     */
    public function isAllowedToVote(User $user, Election $election)
    {
        return $this->electionRules[$election->getGroup()]
            ->isAllowedToVote($user, $election);
    }

    /**
     * Get criterias we should lookup in the database to find elections user
     * is allowed to candidate.
     *
     * @param User $user The user we shoud check.
     *
     * @return array An array of array of criterias with group as key.
     */
    public function getCandidateCriterias(User $user)
    {
        $criterias = array();

        foreach ($this->electionRules as $electionRule) {
            $newCriterias = $electionRule->getCandidateCriterias($user);
            $criterias = array_merge($criterias, $newCriterias);
        }

        return $criterias;
    }

    /**
     * Get criterias we should lookup in the database to find elections user
     * is allowed to vote to.
     *
     * @param User $user The user we should check.
     *
     * @return array An array of array of criterias with group as key.
     */
    public function getVoteCriterias(User $user)
    {
        $criterias = array();

        foreach ($this->electionRules as $electionRule) {
            $newCriterias = $electionRule->getVoteCriterias($user);
            $criterias = array_merge($criterias, $newCriterias);
        }

        return $criterias;
    }

    /**
     * Get the number of votes a user can use in an election.
     *
     * @param User     $user     The user in question.
     * @param Election $election The election.
     *
     * @return integer The number of votes the user can use.
     */
    public function getVoteNumber(User $user, Election $election)
    {
        return $this->electionRules[$election->getGroup()]
            ->getVoteNumber($user, $election);
    }

    public function hasGenderParity(Election $election)
    {
        return $this->electionRules[$election->getGroup()]
            ->hasGenderParity();
    }
}
