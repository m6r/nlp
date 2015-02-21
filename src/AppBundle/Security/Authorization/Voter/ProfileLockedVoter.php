<?php
namespace AppBundle\Security\Authorization\Voter;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ProfileLockedVoter implements VoterInterface
{
    private $enforceLocking;

    public function __construct($enforceLocking)
    {
        $this->enforceLocking = $enforceLocking;
    }

    public function supportsAttribute($attribute)
    {
        return 'IS_PROFILE_LOCKED' === $attribute;
    }

    public function supportsClass($class)
    {
        return true;
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        if (1 !== count($attributes)) {
            throw new \InvalidArgumentException(
                'Only one attribute'
            );
        }

        $attribute = $attributes[0];

        if (!$this->supportsAttribute($attribute)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();

        if (!$user instanceof User) {
            return VoterInterface::ACCESS_DENIED;
        }

        if (!$this->enforceLocking) {
            return VoterInterface::ACCESS_GRANTED;
        }

        return $user->isProfileLocked() ? VoterInterface::ACCESS_GRANTED : VoterInterface::ACCESS_DENIED;
    }
}
