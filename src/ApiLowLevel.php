<?php
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 21.11.2018
 * Time: 23:19
 */

namespace AtolAPI;

use AtolAPI\Exceptions\ApiLowLevelException;


/**
 * Class ApiLowLevel
 * @package AtolAPI
 */
class ApiLowLevel
{
    private $headers = ['Content-Type: application/json; charset=utf-8'];

    private $token = null;

    private $baseUri;


    public function __construct(string $baseUri)
    {
        $this->baseUri = $baseUri;
    }

    public function setToken(string $token)
    {
        $this->token = $token;
        $this->headers[] = 'Token: ' . $token;
    }

    public function call(string $url, array $data, string $type): array
    {

        $url = $this->baseUri . $url;

        if (!empty($data) && $type == 'GET') {
            $url .= '?' . http_build_query($data);
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type);

        if (!empty($data) && $type == 'POST') {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);

        $out = curl_exec($curl);
        $out = json_decode($out, true);
        print_r($out);
        exit();
        curl_close($curl);
        if ($out['error'] !== null) {
            throw new ApiLowLevelException($out['error']['text'], $url, $out['error']['code']);
        }
        return $out;
    }

}