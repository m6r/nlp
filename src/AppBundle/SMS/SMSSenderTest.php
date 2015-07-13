<?php

namespace AppBundle\SMS;

class SMSSenderTest implements SMSSenderInterface
{
    private $mailer;

    private $address;

    public function __construct($mailer, $address)
    {
        $this->mailer = $mailer;
        $this->address = $address;
    }

    public function send($number, $message)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('SMS for '.$number)
            ->setTo($this->address)
            ->setBody($message)
        ;

        $this->mailer->send($message);
    }
}
