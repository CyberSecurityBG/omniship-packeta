<?php

namespace Omniship\Packeta;

use Carbon\Carbon;
use GuzzleHttp\Client as HttpClient;
use http\Client\Response;

class Client
{

    protected $country;
    protected $api_key;
    protected $api_password;
    protected $error;


    public function __construct($country, $api_key, $api_password)
    {
        $this->country = $country;
        $this->api_key = $api_key;
        $this->api_password = $api_password;
    }


    public function getError()
    {
        return $this->error;
    }

    public function SendRequest($method, $endpoint, $data = [])
    {
        try {
            $client = new HttpClient(['base_uri' => $this->ServiceUrl($this->country).'/api/']);
            $response = $client->request($method, $endpoint, [
                'json' => $data,
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            return $this->error = [
                'code' => $e->getCode(),
                'error' => json_decode($e->getResponse()->getBody()->getContents())
            ];
        }

    }

    public function getOffices()
    {
        $branches = $this->SendRequest('GET', $this->api_key.'/branch.json');
        if (is_null($branches)) {
            return $this->getError();
        }
        return $branches;
    }

    public function getPdf($bol_id, $format)
    {
        if ($format == 'A4') {
            $format = 0;
        } else {
            $format = 1;
        }
        return $this->SendRequest('GET', 'AwbDocuments?barCodes=' . $bol_id . '&type=PDF&format=' . $format . '&printMainOnce=0');
    }

    protected function ServiceUrl($country)
    {
        switch ($country) {
            case 'RO':
                $url = 'https://coletaria.ro';
                break;
            case 'CZ':
                $url = 'https://zasilkovna.cz';
                break;
            case 'DE':
                $url = 'https://packeta.de';
                break;
            case 'HU':
                $url = 'https://csomagkuldo.hu';
                break;
            case 'SK':
                $url = 'https://zasielkovna.sk';
                break;
            case 'PL':
                $url = 'https://przesylkownia.pl';
                break;
            default:
                $url = null;
        }
        return $url;
    }
}
