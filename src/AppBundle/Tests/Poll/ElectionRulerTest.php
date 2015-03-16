<?php

namespace AppBundle\Poll\Tests\Poll;

use AppBundle\Entity\User;
use AppBundle\Entity\Poll\Election;
use AppBundle\Poll\ElectionRuler;

class ElectionRulerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->criterias1 = array(
            'group1' => array('criteria1', 'criteria2'),
            'group2' => array('criteria1', 'criteria3'),
        );
        $this->rule1 = $this->getMock('AppBundle\Poll\ElectionRuleInterface');
        $this->rule1->expects($this->any())
            ->method('getValidCriterias')
            ->will($this->returnValue($this->criterias1));
        $this->rule1->expects($this->any())
            ->method('isAllowedToCandidate')
            ->will($this->returnValue(true));
        $this->rule1->expects($this->any())
            ->method('isAllowedToVote')
            ->will($this->returnValue(true));
        $this->rule1->expects($this->any())
            ->method('hasGenderParity')
            ->will($this->returnValue(true));

        $this->criterias2 = array(
            'group3' => array('criteriaA', 'criteriaB'),
        );
        $this->rule2 = $this->getMock('AppBundle\Poll\ElectionRuleInterface');
        $this->rule2->expects($this->any())
            ->method('getValidCriterias')
            ->will($this->returnValue($this->criterias2));
        $this->rule2->expects($this->any())
            ->method('isAllowedToCandidate')
            ->will($this->returnValue(false));
        $this->rule2->expects($this->any())
            ->method('isAllowedToVote')
            ->will($this->returnValue(false));
        $this->rule2->expects($this->any())
            ->method('hasGenderParity')
            ->will($this->returnValue(false));

        $this->election1 = new Election();
        $this->election1->setGroup('group1');
        $this->election1->setCriteria('criteria2');

        $this->election2 = new Election();
        $this->election2->setGroup('group3');
        $this->election2->setCriteria('criteriaA');

        $this->user = $this->getMock('AppBundle\Entity\User');

        $this->ruler = new ElectionRuler();
        $this->ruler->addElectionRule($this->rule1);
        $this->ruler->addElectionRule($this->rule2);
    }

    public function testCriterias()
    {
        $criterias = $this->ruler->getValidCriterias();
        $this->assertEquals(
            array_merge($this->criterias1, $this->criterias2),
            $criterias
        );
    }

    public function testisAllowedToCandidate()
    {
        $this->assertTrue(
            $this->ruler->isAllowedToCandidate($this->user, $this->election1)
        );
    }

    public function testIsAllowedToVote()
    {
        $this->assertFalse(
            $this->ruler->isAllowedToVote($this->user, $this->election2)
        );
    }

    public function testHasGenderParity()
    {
        $this->assertTrue(
            $this->ruler->hasGenderParity($this->election1)
            && !$this->ruler->hasGenderParity($this->election2)
        );
    }
}
