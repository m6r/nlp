<?php

namespace AppBundle\Entity\Poll;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="polls")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 */
abstract class AbstractPoll
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank()
     */
    private $description;

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
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank()
     */
    private $openDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank()
     */
    private $closeDate;

    /**
     * A group for the poll used by authorization checkers. For example
     * "assemblee_2015" for the group of regional elections for the M6R
     * Assemblée Représentative.
     *
     * @var string
     *
     * @ORM\Column(type="string", name="group_name")
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $group;

    /**
     * An identifier (not necessarily unique) used by the auth checker. For
     * example the name of the region for a regional election.
     *
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $criteria;

    /**
     * All user who voted for the poll.
     *
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinTable("polls_voters", inverseJoinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    protected $voters;

    public function __construct()
    {
        $this->voter = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return interger
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name of the poll.
     *
     * @return string The name of the poll.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the description of the poll.
     *
     * @return stringription The description of the poll.
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the opening date of the poll.
     *
     * @return \DateTime THe opening date of the poll.
     */
    public function getOpenDate()
    {
        return $this->openDate;
    }

    /**
     * Get the close date of the poll.
     *
     * @return \DateTime The close date of the poll.
     */
    public function getCloseDate()
    {
        return $this->closeDate;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return string
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * Set the name of the poll.
     *
     * @param string $name The name of the poll.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set the description of the poll.
     *
     * @param string $description The description of the poll.
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Set the opening date of the poll.
     *
     * @param \DateTime $date The opening date of the poll.
     */
    public function setOpenDate(\DateTime $date)
    {
        $this->openDate = $date;
    }

    /**
     * Set the close date of the poll.
     *
     * @param \DateTime $date The close date of the poll.
     */
    public function setCloseDate(\DateTime $date)
    {
        $this->closeDate = $date;
    }

    /**
     * A group for the poll used by authorization checkers. For example
     * "assemblee_2015" for the group of regional elections for the M6R
     * Assemblée Représentative.
     *
     * @param string $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * A unique (within the group) identfier used by the auth checker. For example
     * the name of the region for a regional election.
     *
     * @param string $criteria
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * Add a voter to the vote.
     *
     * @param User $user
     */
    public function addVoter(User $user)
    {
        $this->voters->add($user);
    }

    /**
     * Has a user voted to this election.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function hasVoted(User $user)
    {
        return $this->voters->contains($user);
    }

    /**
     * To string.
     *
     * @return string the name
     */
    public function __toString()
    {
        return $this->name;
    }
}
