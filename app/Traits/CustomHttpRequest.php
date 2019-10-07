<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait CustomHttpRequest
{
    public function makeRequest(
        string $url,
        string $method = "GET",
        array $params = [],
        array $body = [],
        array $headers = [],
        bool $isJson = false
    ) {
        try {
            $client = new Client([
                'base_uri' => $this->baseUri,
            ]);

            if (method_exists($this, 'resolveAuthorization')) {
                $this->resolveAuthorization($params, $body, $headers);
            }

            $response = $client->request($method, $url,  [
                $isJson ? "json" : "form_params" => $body,
                "headers" => $headers,
                "query"=> $params
            ]);
    
            $response = $response->getBody()->getContents();

            if (method_exists($this, 'decodeResponse')) {
                $response = $this->decodeResponse($response);
            }
            
            return $response;
        } catch (\Exception $e) {
            dd($e);
        } catch (GuzzleException $e) {
            dd($e);
        }

        return false;
    }
}
