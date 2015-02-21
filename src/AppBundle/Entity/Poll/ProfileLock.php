<?php

namespace AppBundle\Entity\Poll;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;

/**
 * When the admins start a "lock profile" period, people cannot modify their
 * profile twice until the end of the period. This is usefull for elections
 * for example.
 *
 * @ORM\Table(name="polls_profile_lock")
 * @ORM\Entity()
 */
class ProfileLock
{
    /**
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", inversedBy="profileLocked")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
