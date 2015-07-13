<?php

namespace AppBundle\SMS;

interface SMSSenderInterface
{
    public function send($number, $message);
}
