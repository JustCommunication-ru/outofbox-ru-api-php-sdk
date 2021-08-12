<?php
namespace Outofbox\OutofboxSDK\API;

class AuthTokenResponse
{
    /**
     * @var string
     */
    protected $token;

    /**
     * AuthTokenResponse constructor.
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}