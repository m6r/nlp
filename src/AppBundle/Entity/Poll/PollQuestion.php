<?php

namespace AppBundle\Entity\Poll;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @ORM\Table(name="polls_questions")
 */
class PollQuestion
{
    /**
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * The poll the question is for.
     *
     * @var Poll
     *
     * @ORM\ManyToOne(targetEntity="Poll", inversedBy="questions")
     */
    protected $poll;

    /**
     * The description of the question.
     *
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $text;

    /**
     * All choices in the question.
     *
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="PollChoice", mappedBy="question", cascade={"persist", "remove"})
     */
    protected $choices;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->questions = new ArrayCollection();
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
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set text.
     *
     * @param string $text
     *
     * @return PollQuestion
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set poll.
     *
     * @param Poll $poll
     *
     * @return PollQuestion
     */
    public function setPoll(Poll $poll = null)
    {
        $this->poll = $poll;

        return $this;
    }

    /**
     * Get poll.
     *
     * @return \AppBundle\Entity\Poll\Poll
     */
    public function getPoll()
    {
        return $this->poll;
    }

    /**
     * Add choices.
     *
     * @param PollChoice $choices
     *
     * @return PollQuestion
     */
    public function addChoice(PollChoice $choice)
    {
        $this->choices[] = $choice;
        $choice->setQuestion($this);

        return $this;
    }

    /**
     * Remove choices.
     *
     * @param PollChoice $choice
     */
    public function removeChoice(PollChoice $choice)
    {
        $this->choices->removeElement($choices);
    }

    /**
     * Get choices.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChoices()
    {
        return $this->choices;
    }
}
