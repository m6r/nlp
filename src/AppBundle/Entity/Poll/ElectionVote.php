<?php

namespace AppBundle\Entity\Poll;

use AppBundle\Entity\User;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="polls_election_votes")
 * @ORM\Entity()
 */
class ElectionVote
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
     * @ORM\ManyToOne(targetEntity="Election")
     *
     * @var Election
     */
    private $election;

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
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Candidacy")
     * @ORM\JoinTable("polls_election_votes_candidacies")
     */
    private $candidacies;

    /**
     * Constructor.
     */
    public function __construct(Election $election, $ip, User $user)
    {
        $this->election = $election;
        $this->ip = $ip;
        $this->voter = $user;
        $this->candidacies = new ArrayCollection();
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
     * Add a candidacy to the election. No cascade persist and no synchronization
     * of the inverse side as a candidacy should always be created with an Election.
     *
     * @param Candidacy $candidacy
     */
    public function addCandidacy(Candidacy $candidacy)
    {
        $this->candidacies[] = $candidacy;
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
     * Get election.
     *
     * @return Election
     */
    public function getElection()
    {
        return $this->election;
    }

    /**
     * Check if there are as many women an men in candidacies.
     *
     * @Assert\Callback
     */
    public function checkGenderParity(ExecutionContextInterface $context)
    {
        $count = array('M' => 0, 'F' => 0);
        $total = $this->candidacies->count();

        foreach ($this->candidacies as $candidacy) {
            $gender = $candidacy->getUser()->getGender();
            $count[$gender]++;
            if ($count[$gender] > $total/2) {
                $context->buildViolation('gender_parity')
                    ->atPath('candidacies')
                    ->addViolation();

                return;
            }
        }
    }

    /**
     * Check if all choosen candidacies are candidates to the election.
     *
     * @Assert\Callback
     */
    public function checkCandidacies(ExecutionContextInterface $context)
    {
        foreach ($this->candidacies as $candidacy) {
            if (!$this->election->getCandidacies()->contains($candidacy)) {
                $context->buildViolation('invalidCandidate')
                    ->atPath('candidacies')
                    ->addViolation();
            }
        }
    }
}
