<?php

namespace Uagc;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

/**
 * StacheReader
 *
 * A client for the Stache API
 *
 * @method object get(string $item, string $key)
 *
 */
class StacheReader
{
    /**
     * @var $client object The GuzzleHttp client
     */
    private $client;

    /**
     * @var $stacheUrl string The URL of the Stache API
     */
    private $stacheUrl;

    /**
     * @var $userAgent string The client User-Agent string
     */
    private $userAgent;

    /**
     * The constructor takes a parameter array of the following:
     *
     * - protocol: (string) Request protocol. Defaults to 'https'
     * - port: (string) Request port. Defaults to 443
     * - domain: (string) Domain of the API host. Required. Defaults to null.
     * - user_agent: (string) Request User-Agent. Defaults to 'UA Graduate College StacheReader for PHP'
     *
     * @param array $params Client configuration settings
     */
    public function __construct($params = array())
    {
        $protocol = !empty($params['protocol']) ? $params['protocol'] : 'https';
        $port = !empty($params['port']) ? $params['port'] : '443';
        $apiPath = !empty($params['path']) ? $params['path'] : '/api/v1/item/read/';
        $domain = !empty($params['domain']) ? $params['domain'] : null;
        $this->userAgent = !empty($params['user_agent']) ?
            $params['user_agent'] :
            'UA Graduate College StacheReader for PHP';

        // validate params
        if (!in_array($protocol, ['http', 'https'])) {
            throw new \InvalidArgumentException(
                'Protocol is invalid: ' . $protocol
            );
        }
        if (!is_numeric($port)) {
            throw new \InvalidArgumentException(
                'Port is invalid: ' . $port
            );
        }
        if (!is_string($apiPath)) {
            throw new \InvalidArgumentException(
                'API Path is invalid: ' . $apiPath
            );
        }
        if (!is_string($domain)) {
            throw new \InvalidArgumentException(
                'Domain is invalid: ' . $domain
            );
        }
        if (!is_string($this->userAgent)) {
            throw new \InvalidArgumentException(
                'User-Agent is invalid: ' . $this->userAgent
            );
        }

        $this->stacheUrl = $protocol . '://' . $domain . ':' . $port . $apiPath;
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * Get the requested item from Stache
     *
     * @param string $item The Stached item's number
     * @param string $key The Stached item's key
     *
     * @return object A PHP stdObject constructed by passing the response body through json_decode()
     */
    public function read($item=null, $key=null)
    {
        if (empty($item) || empty($key)) {
            throw new \InvalidArgumentException(
                'The item, key, or both were not specified'
            );
        }

        $headers = [
            'User-Agent' => $this->userAgent,
            'X-STACHE-READ-KEY' => $key
        ];

        $itemUrl = $this->stacheUrl . $item;
        $response = $this->client->request(
            'GET',
            $itemUrl,
            [
                'headers' => $headers
            ]
        );

        $responseStatus = $response->getStatusCode();
        $responseBody = $response->getBody();

        if ($responseStatus !== 200) {
            throw new \Exception(
                'Error ' . $responseStatus . ': ' . $responseBody
            );
        }

        return json_decode((string) $responseBody);
    }

    /**
     * Asyncronous request of the item from Stache
     *
     * @param string $item The Stached item's number
     * @param string $key The Stached item's key
     *
     * @return GuzzleHttp\Promise object that will resolve to a PHP stdObject constructed by passing the response body through json_decode()
     */
    public function fetch($item=null, $key=null)
    {
    }
}
