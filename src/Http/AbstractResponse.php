<?php

namespace Omniship\Packeta\Http;

use Omniship\Packeta\Client;
use Omniship\Message\AbstractResponse AS BaseAbstractResponse;

class AbstractResponse extends BaseAbstractResponse
{

    protected $error;

    protected $errorCode;

    protected $client;


    /**
     * Get the initiating request object.
     *
     * @return AbstractRequest
     */
    public function getRequest()
    {
       return  $this->request;
    }

    /**
     * @return null|string
     */
    public function getMessage()
    {
        return null;
    }

    /**
     * @return null|string
     */
    public function getCode()
    {
        if(!is_null($this->getClient()->getError()) && $this->getClient()->getError()['code'] != 200) {
            if($this->getMessage() != 'There is no active user with the provided credential!') {
                return $this->getMessage();
            } else {
                return null;
            }
        }
        return null;
    }

    /**
     * @return null|Client
     */
    public function getClient()
    {
        return $this->getRequest()->getClient();
    }

    /**
     * @param mixed $client
     * @return AbstractResponse
     */


}
