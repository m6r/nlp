<?php

namespace AppBundle\Entity\Poll;

use Doctrine\ORM\EntityRepository;

class ElectionRepository extends EntityRepository
{
    public function findAllCurrent()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT election
            FROM AppBundle:Poll\Election election
            WHERE election.openCandidacyDate < CURRENT_TIMESTAMP()
            AND election.closeDate > CURRENT_TIMESTAMP()
            ORDER BY election.closeDate ASC'
        )
        ->getResult();
    }

    public function findAllPast()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT election
            FROM AppBundle:Poll\Election election
            WHERE election.closeDate < CURRENT_TIMESTAMP()
            ORDER BY election.closeDate ASC'
        )
        ->getResult();
    }
}
