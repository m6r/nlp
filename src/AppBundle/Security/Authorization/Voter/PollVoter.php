<?php
namespace AppBundle\Security\Authorization\Voter;

use AppBundle\Entity\User;
use AppBundle\Poll\ElectionRuler;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class PollVoter implements VoterInterface
{
    public function supportsAttribute($attribute)
    {
        return 0 === strpos($attribute, 'POLL_');
    }

    public function supportsClass($class)
    {
        $supportedClass = 'AppBundle\Entity\Poll\Poll';

        return $supportedClass === $class || is_subclass_of($class, $supportedClass);
    }

    public function vote(TokenInterface $token, $election, array $attributes)
    {
        // check if class of this object is supported by this voter
        if (!$this->supportsClass(get_class($election))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // check if the voter is used correct, only allow one attribute
        // this isn't a requirement, it's just one easy way for you to
        // design your voter
        if (1 !== count($attributes)) {
            throw new \InvalidArgumentException(
                'Only one attribute is allowed.'
            );
        }

        // set the attribute to check against
        $attribute = $attributes[0];

        // check if the given attribute is covered by this voter
        if (!$this->supportsAttribute($attribute)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();

        if (!$user instanceof User) {
            return VoterInterface::ACCESS_DENIED;
        }

        switch ($attribute) {
            case 'POLL_VOTE':
                $opened = (new \DateTime() > $election->getOpenDate());
                $closed = (new \DateTime() > $election->getCloseDate());
                $hasVoted = $election->hasVoted($user);

                if ($opened && !$closed && !$hasVoted) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
