<?php

namespace AppBundle\Entity\Poll;

use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="polls_votes")
 * @ORM\Entity()
 */
class PollVote
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
     * @ORM\ManyToOne(targetEntity="Poll")
     *
     * @var Poll
     */
    private $poll;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=46)
     *
     * @Assert\Ip()
     * @Assert\NotBlank()
     */
    private $ip;

    /**
     * @var AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    private $voter;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PollQuestionVote", mappedBy="vote", cascade={"persist", "remove"})
     */
    private $questionVotes;

    /**
     * Constructor.
     */
    public function __construct(Poll $poll, $ip, User $user)
    {
        $this->poll = $poll;
        $this->ip = $ip;
        $this->voter = $user;
        $this->questionVotes = new ArrayCollection();

        foreach ($poll->getQuestions() as $question) {
            $this->questionVotes->add(new PollQuestionVote($this, $question));
        }
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
     * Get IP.
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set IP.
     *
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Get poll.
     *
     * @return Election
     */
    public function getPoll()
    {
        return $this->poll;
    }

    /**
     * Get voter.
     *
     * @return \AppBundle\Entity\User
     */
    public function getVoter()
    {
        return $this->voter;
    }

    /**
     * Get questionVotes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionVotes()
    {
        return $this->questionVotes;
    }
}
