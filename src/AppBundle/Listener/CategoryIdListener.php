<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Category;
use Doctrine\ORM\Event\LifecycleEventArgs;

class CategoryIdListener
{
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();

        if ($entity instanceof Category) {
            $ok = $entity->updateLegacyId();

            if (!$ok) {
                $eventArgs->getEntityManager()->persist($entity);
                $eventArgs->getEntityManager()->flush();
            }
        }
    }
}
