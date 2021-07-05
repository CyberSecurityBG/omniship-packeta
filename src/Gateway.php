<?php

namespace Omniship\Packeta;

use Omniship\Packeta\Http\ValidateCredentialsRequest;
//use Omniship\Cargus\Http\GetPdfRequest;
//use Omniship\Cargus\Http\ShippingQuoteRequest;
//use Omniship\Cargus\Http\CreateBillOfLadingRequest;

use Omniship\Common\AbstractGateway;
use Omniship\Packeta\Client;

class Gateway extends AbstractGateway
{

    private $name = 'Packeta';
    protected $client;
    const TRACKING_URL = '';

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
     * @param $country
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'country' => '',
            'api_key' => '',
            'api_password' => '',
        );
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

    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->getParameter('endpoint');
    }

    public function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new Client($this->getCountry(), $this->getApiKey(), $this->getApiPassword());
        }

        return $this->client;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setEndpoint($value)
    {
        return $this->setParameter('endpoint', $value);
    }

    public function supportsValidateCredentials(){
        return true;
    }


    public function validateCredentials(array $parameters = [])
    {
        return $this->createRequest(ValidateCredentialsRequest::class, $parameters);
    }


    public function getQuotes($parameters = [])
    {
        if($parameters instanceof ShippingQuoteRequest) {
            return $parameters;
        }
        if(!is_array($parameters)) {
            $parameters = [];
        }
        return $this->createRequest(ShippingQuoteRequest::class, $this->getParameters() + $parameters);
    }
    public function supportsCashOnDelivery()
    {
        return true;
    }

    public function supportsCreateBillOfLading(){
        return true;
    }

    public function createBillOfLading($parameters = [])
    {
        if ($parameters instanceof CreateBillOfLadingRequest) {
            return $parameters;
        }
        if (!is_array($parameters)) {
            $parameters = [];
        }
        return $this->createRequest(CreateBillOfLadingRequest::class, $this->getParameters() + $parameters);
    }

    public function getPdf($bol_id)
    {
        return $this->createRequest(GetPdfRequest::class, $this->setBolId($bol_id)->getParameters());
    }

    public function trackingUrl($parcel_id)
    {
        return sprintf(static::TRACKING_URL, $parcel_id);
    }
}
