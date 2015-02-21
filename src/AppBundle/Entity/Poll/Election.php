<?php

namespace AppBundle\Entity\Poll;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Poll\ElectionRepository")
 */
class Election extends GenericPoll
{
    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     *
     * @Assert\NotBlank()
     */
    private $openCandidacyDate;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \Datetime
     *
     * @Assert\NotBlank()
     */
    private $closeCandidacyDate;

    /**
     * The candidates to the election. We do not use the choice property.
     *
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Candidacy", mappedBy="election")
     */
    protected $candidacies;

    public function __construct()
    {
        $this->candidates = new ArrayCollection();
    }

    /**
     * Get the opening date of the candidacies.
     *
     * @return \DateTime THe opening date of the poll.
     */
    public function getOpenCandidacyDate()
    {
        return $this->openCandidacyDate;
    }

    /**
     * Get the close date of the candidacies.
     *
     * @return \DateTime The close date of the poll.
     */
    public function getCloseCandidacyDate()
    {
        return $this->closeCandidacyDate;
    }

    /**
     * Set the opening date of the candidacy.
     *
     * @param \DateTime $date The opening date of the poll.
     */
    public function setOpenCandidacyDate(\DateTime $date)
    {
        $this->openCandidacyDate = $date;
    }

    /**
     * Set the close date of the candidacy.
     *
     * @param \DateTime $date The close date of the poll.
     */
    public function setCloseCandidacyDate(\DateTime $date)
    {
        $this->closeCandidacyDate = $date;
    }

    /**
     * Get all candidacies.
     *
     * @return ArrayCollection
     */
    public function getCandidacies()
    {
        return $this->candidacies;
    }

    /**
     * Is a user candidate to the election.
     *
     * @param AppBundle\Entity\User $user
     *
     * @return boolean
     */
    public function isCandidate(\AppBundle\Entity\User $user)
    {
        foreach ($this->candidacies as $candidacy) {
            if ($candidacy->getUser() === $user) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add a candidacy to the election. No cascade persist and no synchronization
     * of the inverse side as a candidacy should always be created with an Election.
     *
     * @param Candidacy $candidacy
     */
    public function addCandidacy(Candidacy $candidacy)
    {
        $this->candidacies[] = $candidacy;
    }
}
