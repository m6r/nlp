<?php

namespace AppBundle\SMS;

use Ovh\Api;

class SMSSenderOVH implements SMSSenderInterface
{
    /**
     * @var string
     */
    private $applicationKey;

    /**
     * @var string
     */
    private $applicationSecret;

    /**
     * @var string
     */
    private $consumerKey;

    /**
     * @var string
     */
    private $serviceName;

    /**
     * Constructor.
     *
     * @param string $applicationKey
     * @param string $applicationSecret
     * @param string $consumerKey
     * @param string $serviceName
     */
    public function __construct($applicationKey, $applicationSecret, $consumerKey, $serviceName)
    {
        $this->applicationKey = $applicationKey;
        $this->applicationSecret = $applicationSecret;
        $this->consumerKey = $consumerKey;
        $this->serviceName = $serviceName;
    }

    /**
     * Send a sms.
     *
     * @param string $number
     * @param string $message
     */
    public function send($number, $message)
    {
        $conn = new Api($this->applicationKey, $this->applicationSecret, 'ovh-eu', $this->consumerKey);

        $result = $conn->post('/sms/'.$this->serviceName.'/jobs/', (object) array(
            'charset' => 'UTF-8',
            'class' => 'phoneDisplay',
            'coding' => '7bit',
            'message' => $message,
            'noStopClause' => true,
            'priority' => 'high',
            'receivers' => array($number),
            'senderForResponse' => true,
            'validityPeriod' => 2880,
        ));

        return empty($result['invalidReceivers']);
    }
}
