<?php

namespace Omniship\Packeta\Http;

use Omniship\Packeta\Client as PacketaClient;

use Omniship\Message\AbstractRequest as BaseAbstractRequest;
use Omniship\Packeta\Gateway;

abstract class AbstractRequest extends BaseAbstractRequest
{
    protected $client;

    /**
     * @return stringc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return stringc
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    public function getApiKey() {
        return $this->getParameter('api_key');
    }

    public function setApiKey($value) {
        return $this->setParameter('api_key', $value);
    }

    public function getApiPassword() {
        return $this->getParameter('api_password');
    }

    public function setApiPassword($value) {
        return $this->setParameter('api_password', $value);
    }


    public function getClient()
    {
        if(is_null($this->client)) {
            $this->client = new PacketaClient($this->getCountry(), $this->getApiKey(), $this->getApiPassword());
        }

        return $this->client;
    }

    abstract protected function createResponse($data);

}
