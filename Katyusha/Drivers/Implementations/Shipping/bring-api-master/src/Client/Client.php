<?php

namespace Trafficfox\Bring\API\Client;

abstract class Client
{
    protected Credentials $_credentials;

    protected \GuzzleHttp\ClientInterface $_client;

    public function __construct(Credentials $credentials, ?\GuzzleHttp\ClientInterface $client = null)
    {
        $this->_credentials = $credentials;

        if ($client === null) {
            $client = new \GuzzleHttp\Client();
        }
        $this->_client = $client;
    }

    public function setClient(\GuzzleHttp\ClientInterface $client): void
    {
        $this->_client = $client;
    }

    protected function request($method, $endpoint, array $options = []): mixed
    {
        $options = array_merge([
            'headers' => [
                'Accept' => 'application/json',
            ],
        ], $options);

        if ($credentials = $this->_credentials) {
            $options['headers']['X-Bring-Client-URL'] = $credentials->getClientUrl();

            if ($credentials->getClientId() !== null) {
                $options['headers']['X-MyBring-API-Uid'] = $credentials->getClientId();
            }

            if ($credentials->getApiKey() !== null) {
                $options['headers']['X-MyBring-API-Key'] = $credentials->getApiKey();
            }
        }

        return $this->_client->request($method, $endpoint, $options);
    }

    protected function xmlRequest($method, $endpoint, array $options = [])
    {
        $options = array_merge([
            'headers' => [
                'Accept' => 'text/xml',
                'Content-type' => 'text/xml',
            ],
        ], $options);

        return $this->request($method, $endpoint, $options);
    }

    /**
     * https://github.com/guzzle/guzzle/issues/1196.
     */
    protected function getQueryParams(array $data): string
    {
        $add = '';
        foreach ($data as $k => $arr) {
            if (is_array($arr)) {
                foreach ($arr as $value) {
                    $add .= "&${k}=".urlencode($value);
                }
                unset($data[$k]);
            } elseif ($arr === null) {
                unset($data[$k]);
            } elseif (is_bool($arr)) {
                $data[$k] = $arr ? 'true' : 'false';
            }
        }

        return http_build_query($data).$add;
    }
}
