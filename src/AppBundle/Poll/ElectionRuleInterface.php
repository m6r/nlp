<?php

namespace AppBundle\Poll;

use AppBundle\Entity\User;
use AppBundle\Entity\Poll\Election;

interface ElectionRuleInterface
{
    /**
     * Should return an array of arrays with groups in key and criteria ids
     * in values of each array like array('group1' => array('criteria1', 'criteria2'))
     * This is called only once so should always return the same.
     *
     * @return array
     */
    public function getValidCriterias();

    /**
     * Should the elections be organized to chose equal number of women and men.
     *
     * @return boolean
     */
    public function hasGenderParity();

    /**
     * Is the user allowed to candidate to an election.
     *
     * @param User     $user     The user we should check.
     * @param Election $election The election we are talking about.
     *
     * @return boolean
     */
    public function isAllowedToCandidate(User $user, Election $election);

    /**
     * Is the user allowed to vote in an election.
     *
     * @param User     $user     The user we should check.
     * @param Election $election The election we are talking about.
     *
     * @return boolean
     */
    public function isAllowedToVote(User $user, Election $election);

    /**
     * Get criterias we should lookup in the database to find elections user
     * is allowed to candidate.
     *
     * @param User $user The user we shoud check.
     *
     * @return array An array of array of criterias with group as key.
     */
    public function getCandidateCriterias(User $user);

    /**
     * Get criterias we should lookup in the database to find elections user
     * is allowed to vote to.
     *
     * @param User $user The user we should check.
     *
     * @return array An array of array of criterias with group as key.
     */
    public function getVoteCriterias(User $user);

    /**
     * Get the number of votes a user can use in an election.
     *
     * @param User     $user     The user in question.
     * @param Election $election The election.
     *
     * @return integer The number of votes the user can use.
     */
    public function getVoteNumber(User $user, Election $election);

    /**
     * Get the maximum number of winners there can be in an election.
     *
     * @param  Election $election The number of winners
     * @return integer
     */
    public function getWinnersNumber(Election $election);
}
