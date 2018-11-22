<?php
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 21.11.2018
 * Time: 23:45
 */

namespace AtolAPI;

use AtolAPI\ApiLowLevel;
use AtolAPI\Exceptions\ApiLowLevelException;

class ApiHighLevel
{

    private $apiVersion = 'v4';
    private $client;

    public function __construct($apiVersion = 'v4')
    {
        $this->apiVersion = $apiVersion;
        $this->client = new ApiLowLevel('https://online.atol.ru/possystem/' . $this->apiVersion . '/');
    }

    public function auth(string $login, string $pass, string $type = 'POST'): array
    {
        try {
            $authData = $this->client->call('getToken', ['login' => $login, 'pass' => $pass], $type);
        } catch (ApiLowLevelException $e) {
            $return = [
                'status' => 'error',
                'data' => [
                    'url' => $e->getUrl(),
                    'text' => $e->getMessage(),
                    'code' => $e->getCode()
                ]
            ];
            // можно добавить сразу тут в лог
            return $return;
        }
        $this->client->setToken($authData['token']);
        $return = [
            'status' => 'success',
            'data' => $authData
        ];
        return $return;
    }

    public function sell(array $data): array
    {
        try {
            $authData = $this->client->call('sell', $data, 'POST');
        } catch (ApiLowLevelException $e) {
            $return = [
                'status' => 'error',
                'data' => [
                    'url' => $e->getUrl(),
                    'text' => $e->getMessage(),
                    'code' => $e->getCode()
                ]
            ];
            // можно добавить сразу тут в лог
            return $return;
        }
        $return = [
            'status' => 'success',
            'data' => $authData
        ];
        return $return;
    }

    /**
     * @return string
     */
    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    /**
     * @param string $apiVersion
     */
    public function setApiVersion(string $apiVersion): void
    {
        $this->apiVersion = $apiVersion;
    }


}