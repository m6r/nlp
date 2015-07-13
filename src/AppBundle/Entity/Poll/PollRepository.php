<?php

namespace AppBundle\Entity\Poll;

use Doctrine\ORM\EntityRepository;

class PollRepository extends EntityRepository
{
    public function findAllCurrent()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT poll
            FROM AppBundle:Poll\Poll poll
            WHERE poll.openDate < CURRENT_TIMESTAMP()
            AND poll.closeDate > CURRENT_TIMESTAMP()
            ORDER BY poll.closeDate ASC'
        )
        ->getResult();
    }

    public function findAllPast()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT poll
            FROM AppBundle:Poll\Poll poll
            WHERE poll.closeDate < CURRENT_TIMESTAMP()
            ORDER BY poll.closeDate ASC'
        )
        ->getResult();
    }
}
