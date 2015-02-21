<?php

namespace AppBundle\Entity\Poll;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @ORM\Table(name="polls_choices")
 */
class Choice
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
     * The election the candidacy is for.
     *
     * @var GenericPoll
     *
     * @ORM\ManyToOne(targetEntity="GenericPoll", inversedBy="choices")
     */
    protected $election;

    /**
     * The name of the poll choice.
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * The description of the poll choice.
     *
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $description;
}
