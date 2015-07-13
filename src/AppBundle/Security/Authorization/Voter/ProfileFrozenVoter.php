<?php

namespace AppBundle\Security\Authorization\Voter;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class ProfileFrozenVoter implements VoterInterface
{
    private $enforceFreezing;

    public function __construct($enforceFreezing)
    {
        $this->enforceFreezing = $enforceFreezing;
    }

    public function supportsAttribute($attribute)
    {
        return 'IS_PROFILE_LOCKED' === $attribute || 'IS_PROFILE_FROZEN' === $attribute;
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

        if (!$this->enforceFreezing) {
            return VoterInterface::ACCESS_GRANTED;
        }

        return $user->isProfileFrozen() ? VoterInterface::ACCESS_GRANTED : VoterInterface::ACCESS_DENIED;
    }
}
