<?php

namespace AppBundle\Entity\Poll;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Poll\PollRepository")
 */
class Poll extends GenericPoll
{
}
