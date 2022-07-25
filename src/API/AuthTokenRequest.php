<?php

namespace Outofbox\OutofboxSDK\API;

class AuthTokenRequest extends AbstractRequest
{
    const HTTP_METHOD = 'PUT';
    const URI = '/_api/v1/security/token';
    const RESPONSE_CLASS = AuthTokenResponse::class;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * AuthTokenRequest constructor.
     *
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function createHttpClientParams()
    {
        return [
            'form_params' => [
                'username' => $this->username,
                'password' => $this->password
            ]
        ];
    }
}
