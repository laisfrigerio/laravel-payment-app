<?php

namespace App\Services;

use App\Traits\CustomHttpRequest;

class PaypalService
{
    use CustomHttpRequest;
    
    /**
     * @var string
     */
    protected  $baseUri;
    
    /**
     * @var string
     */
    protected $clientSecret;
    
    /**
     * @var string
     */
    protected $clientId;
    
    public function __construct()
    {
        $this->baseUri = config("services.paypal.base_uri");
        $this->clientSecret = config("services.paypal.client_secret");
        $this->clientId = config("services.paypal.client_id");
    }
    
    public function decodeResponse($response)
    {
        return json_decode($response);
    }
    
    public function resolveAuthorization(&$params, &$body, &$headers)
    {
        $headers["Authorization"] = $this->resolveAccessToken();
    }
    
    private function resolveAccessToken()
    {
        $credentials = base64_encode("{$this->clientId}:{$this->clientSecret}");
        return "Basic {$credentials}";
    }
}
