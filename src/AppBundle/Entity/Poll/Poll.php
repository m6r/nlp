<?php

namespace AppBundle\Entity\Poll;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Poll\PollRepository")
 */
class Poll extends AbstractPoll
{
    /**
     * All questions asked in the poll.
     *
     * @var array
     *
     * @ORM\OneToMany(targetEntity="PollQuestion", mappedBy="poll")
     */
    protected $questions;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->setGroup('default');
        $this->setCriteria('default');
    }

    /**
     * Add questions.
     *
     * @param PollChoice $questions
     *
     * @return Poll
     */
    public function addQuestion(PollChoice $questions)
    {
        $this->questions[] = $questions;

        return $this;
    }

    /**
     * Remove questions.
     *
     * @param PollChoice $questions
     */
    public function removeQuestion(PollChoice $questions)
    {
        $this->questions->removeElement($questions);
    }

    /**
     * Get questions.
     *
     * @return Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }
}
