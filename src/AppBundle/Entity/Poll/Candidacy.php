<?php

namespace AppBundle\Entity\Poll;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="polls_election_candidacies")
 */
class Candidacy
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
     * The user linked to the candidacy.
     *
     * @var array
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     *
     * @Assert\Type(type="AppBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;

    /**
     * The election the candidacy is for.
     *
     * @var Election
     *
     * @ORM\ManyToOne(targetEntity="Election", inversedBy="candidacies")
     */
    protected $election;

    /**
     * The description of the candidacy.
     *
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Length(max=3000)
     */
    protected $description;

    /**
     * Do the candidate want to stay anonyous.
     *
     * @var bool
     *
     * @ORM\Column(type="boolean")
     *
     * @Assert\Type("boolean")
     */
    private $hideIdentity;

    public function __construct(Election $election)
    {
        $this->election = $election;
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
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Candidacy
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
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
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return Candidacy
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
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
     * Set description.
     *
     * @param string $description
     *
     * @return Candidacy
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Candidacy
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set election.
     *
     * @param \AppBundle\Entity\Poll\Election $election
     *
     * @return Candidacy
     */
    public function setElection(\AppBundle\Entity\Poll\Election $election = null)
    {
        $this->election = $election;

        return $this;
    }

    /**
     * Get election.
     *
     * @return \AppBundle\Entity\Poll\Election
     */
    public function getElection()
    {
        return $this->election;
    }

    /**
     * Set hideIdentity.
     *
     * @param bool $hideIdentity
     *
     * @return Candidacy
     */
    public function setHideIdentity($hideIdentity)
    {
        $this->hideIdentity = $hideIdentity;

        return $this;
    }

    /**
     * Get hideIdentity.
     *
     * @return bool
     */
    public function getHideIdentity()
    {
        return $this->hideIdentity;
    }
}
