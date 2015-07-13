<?php

namespace AppBundle\Entity\Poll;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="polls_votes_choices")
 * @ORM\Entity()
 */
class PollQuestionVote
{
    /**
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var PollVote
     *
     * @ORM\ManyToOne(targetEntity="PollVote", inversedBy="questionVotes")
     */
    private $vote;

    /**
     * @var PollChoice
     *
     * @ORM\ManyToOne(targetEntity="PollChoice")
     * @Assert\NotBlank()
     */
    private $choice;

    /**
     * @var PollQuestion
     *
     * @ORM\ManyToOne(targetEntity="PollQuestion")
     */
    private $question;

    /**
     * Constructor.
     */
    public function __construct(PollVote $vote, PollQuestion $question)
    {
        $this->vote = $vote;
        $this->question = $question;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get vote.
     *
     * @return \AppBundle\Entity\Poll\PollVote
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set choice.
     *
     * @param \AppBundle\Entity\Poll\PollChoice $choice
     *
     * @return PollQuestionVote
     */
    public function setChoice(PollChoice $choice = null)
    {
        $this->choice = $choice;

        return $this;
    }

    /**
     * Get choice.
     *
     * @return \AppBundle\Entity\Poll\PollChoice
     */
    public function getChoice()
    {
        return $this->choice;
    }

    /**
     * Get question.
     *
     * @return \AppBundle\Entity\Poll\PollQuestion
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
