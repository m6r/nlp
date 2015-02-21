<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class Sha256PliggEncoder implements PasswordEncoderInterface
{
    public function encodePassword($raw, $salt = null)
    {
        if ($salt === null) {
            $salt = substr(md5(uniqid(rand(), true)), 0, 9);
        } else {
            $salt = substr($salt, 0, 9);
        }

        return $salt.hash('sha512', $salt.$raw);
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        return $encoded === $this->encodePassword($raw, $salt);
    }
}
