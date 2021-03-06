<?php

namespace BitWasp\CommonBlockchain;

use Afk11\MiniRest\BadResponseException;
use Afk11\MiniRest\RestClientInterface;

abstract class AbstractRepo
{
    /**
     * @var string
     */
    protected $repo;

    /**
     * @var RestClientInterface
     */
    protected $client;

    /**
     * AbstractRepo constructor.
     * @param RestClientInterface $client
     */
    public function __construct(RestClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getRepo()
    {
        return $this->repo;
    }

    /**
     * @param string $repo
     * @return $this
     */
    protected function setName($repo)
    {
        $this->repo = $repo;
        return $this;
    }

    /**
     * @param string $value
     * @return array|string
     */
    protected function arrayOrString($value)
    {
        if (is_string($value)) {
            $value = [$value];
        }

        if (!is_array($value)) {
            throw new \InvalidArgumentException('Invalid argument passed, neither array or string');
        }

        return $value;
    }

    /**
     * @param $endpoint
     * @param array $body
     * @return array
     * @throws BadResponseException
     */
    protected function makeRequest($endpoint, $body = [])
    {
        try {
            $response = $this->client->post($this->repo . "/" . $endpoint, null, $body);
            return $response;
        } catch (BadResponseException $e) {
            throw $e;
        }
    }
}