<?php

namespace AppBundle\Poll\Tests\Poll;

use AppBundle\Entity\User;
use AppBundle\Entity\Poll\Election;
use AppBundle\Poll\DefaultElectionRule;
use AppBundle\Poll\ElectionRuler;

class DefaultElectionRuleTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->user = $this->getMock('AppBundle\Entity\User');
        $this->ruler = new ElectionRuler();
        $this->ruler->addElectionRule(new DefaultElectionRule());

        $this->election = new Election();
        $this->election->setGroup('default');
        $this->election->setCriteria('gender_parity');
    }

    public function testCriterias()
    {
        $this->assertEquals(
            array('default' => array('gender_parity')),
            $this->ruler->getValidCriterias()
        );
    }

    public function testisAllowedToCandidate()
    {
        $this->assertTrue(
            $this->ruler->isAllowedToCandidate($this->user, $this->election)
        );
    }

    public function testIsAllowedToVote()
    {
        $this->assertTrue(
            $this->ruler->isAllowedToVote($this->user, $this->election)
        );
    }

    public function testHasGenderParity()
    {
        $this->assertTrue(
            $this->ruler->hasGenderParity($this->election)
        );
    }

    public function testgetCandidateCriterias()
    {
        $this->assertEquals(
            $this->ruler->getValidCriterias($this->election),
            $this->ruler->getCandidateCriterias($this->user, $this->election)
        );
    }

    public function testgetVoteCriterias()
    {
        $this->assertEquals(
            $this->ruler->getValidCriterias($this->election),
            $this->ruler->getVoteCriterias($this->user, $this->election)
        );
    }
}
