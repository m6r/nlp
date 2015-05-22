<?php

namespace AppBundle\Poll;

use AppBundle\Entity\User;
use AppBundle\Entity\Poll\AbstractPoll;

interface PollRuleInterface
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
     * Is the user allowed to vote in an election.
     *
     * @param User         $user The user we should check.
     * @param AbstractPoll $poll The election we are talking about.
     *
     * @return boolean
     */
    public function isAllowedToVote(User $user, AbstractPoll $poll);

    /**
     * Get criterias we should lookup in the database to find elections user
     * is allowed to vote to.
     *
     * @param User $user The user we should check.
     *
     * @return array An array of array of criterias with group as key.
     */
    public function getVoteCriterias(User $user);
}
