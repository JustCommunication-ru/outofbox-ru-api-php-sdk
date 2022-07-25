<?php

namespace Outofbox\OutofboxSDK;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Outofbox\OutofboxSDK\API\AuthTokenRequest;
use Outofbox\OutofboxSDK\API\RequestInterface;
use Outofbox\OutofboxSDK\API\ResponseInterface;
use Outofbox\OutofboxSDK\Exception\OutofboxAPIException;
use Outofbox\OutofboxSDK\Serializer\ProductDenormalizer;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class OutofboxAPIClient
 *
 * @package Outofbox\OutofboxSDK
 *
 * @method API\AuthTokenResponse sendAuthTokenRequest(API\AuthTokenRequest $request)
 * @method API\ProductsListResponse sendProductsListRequest(API\ProductsListRequest $request)
 * @method API\ProductsListResponse sendContractorsProductsListRequest(API\Products\ContractorProductsListRequest $request)
 * @method API\ProductViewResponse sendProductViewRequest(API\ProductViewRequest $request)
 * @method API\Products\ProductUpdateResponse sendProductUpdateRequest(API\Products\ProductUpdateRequest $request)
 * @method API\Categories\CategoriesListResponse sendCategoriesListRequest(API\Categories\CategoriesListRequest $request)
 * @method API\Warehouse\StoresListResponse sendStoresListRequest(API\Warehouse\StoresListRequest $request)
 * @method API\ShopOrders\CreateShopOrderResponse sendCreateShopOrderRequest(API\ShopOrders\CreateShopOrderRequest $request)
 * @method API\Shipments\ShipmentRegisterResponse sendShipmentRegisterRequest(API\Shipments\ShipmentRegisterRequest $request)
 */
class OutofboxAPIClient implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected static $default_http_client_options = [
        'connect_timeout' => 4,
        'timeout' => 10
    ];

    /**
     * @var string
     */
    protected $base_uri;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * OutofboxAPIClient constructor.
     *
     * @param string $base_uri
     * @param string $username
     * @param string $token
     * @param Client|array|null $httpClientOrOptions
     */
    public function __construct($base_uri, $username, $token, $httpClientOrOptions = null)
    {
        $this->base_uri = $base_uri;
        $this->username = $username;
        $this->token = $token;

        $this->httpClient = self::createHttpClient($httpClientOrOptions);

        $this->logger = new NullLogger();

        $this->serializer = new Serializer([
            new ProductDenormalizer(),
            new ArrayDenormalizer(),
            new ObjectNormalizer(null, null, null, new PhpDocExtractor())
        ]);
    }

    /**
     * Get auth token
     *
     * @param string $password
     * @param Client|array|null $httpClientOrOptions
     * @return string
     */
    public function getAuthToken($password, $httpClientOrOptions = null)
    {
        $response = $this->sendAuthTokenRequest(new AuthTokenRequest($this->username, $password));
        return $response->getToken();
    }

    public function __call($name, array $arguments)
    {
        if (0 === \strpos($name, 'send')) {
            return call_user_func_array([$this, 'sendRequest'], $arguments);
        }

        throw new \BadMethodCallException(\sprintf('Method [%s] not found in [%s].', $name, __CLASS__));
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     *
     * @throws OutofboxAPIException
     */
    public function sendRequest(RequestInterface $request)
    {
        try {
            /** @var Response $response */
            $response = $this->createAPIRequestPromise($request)->wait();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            self::handleErrorResponse($e->getResponse(), $this->logger);

            throw new OutofboxAPIException('Outofbox API Request error: ' . $e->getMessage());
        }

        return $this->createAPIResponse($response, $request->getResponseClass());
    }

    public function createAPIRequestPromise(RequestInterface $request)
    {
        $request_params = $request->createHttpClientParams();

        $this->logger->debug('Outofbox API request {method} {uri}', [
            'method' => $request->getHttpMethod(),
            'uri' => $request->getUri(),
            'request_params' => $request_params
        ]);

        if ($this->token) {
            $request_params = array_merge_recursive($request_params, [
                'headers' => [
                    'X-WSSE' => $this->generateWsseHeader()
                ]
            ]);
        }

        if (!isset($request_params['base_uri'])) {
            $request_params['base_uri'] = $this->base_uri;
        }

        /*
        $stack = HandlerStack::create();
        $stack->push(
            Middleware::log(
                $this->logger,
                new MessageFormatter(MessageFormatter::DEBUG)
            )
        );

        $params['handler'] = $stack;
        */

        return $this->httpClient->requestAsync($request->getHttpMethod(), $request->getUri(), $request_params);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param string $apiResponseClass
     *
     * @return ResponseInterface
     *
     * @throws OutofboxAPIException
     */
    protected function createAPIResponse(\Psr\Http\Message\ResponseInterface $response, $apiResponseClass)
    {
        $response_string = (string)$response->getBody();
        $response_data = json_decode($response_string, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new OutofboxAPIException('Invalid response data');
        }

        if (isset($response_data['code'], $response_data['message'])) {
            throw new OutofboxAPIException('Outofbox API Error: ' . $response_data['message'], $response_data['code']);
        }

        try {
            /** @var ResponseInterface $response */
            $response = $this->serializer->denormalize($response_data, $apiResponseClass);
        } catch (\Symfony\Component\Serializer\Exception\RuntimeException $e) {
            throw new OutofboxAPIException('Unable to decode response: ' . $e->getMessage());
        }

        return $response;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface|null $response
     * @throws OutofboxAPIException
     */
    protected static function handleErrorResponse(\Psr\Http\Message\ResponseInterface $response = null, \Psr\Log\LoggerInterface $logger = null)
    {
        if (!$response) {
            return;
        }

        $response_string = (string)$response->getBody();

        if ($response_string) {
            $response_data = json_decode($response_string, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new OutofboxAPIException('Unable to decode error response data. Error: ' . json_last_error_msg());
            }

            if (isset($response_data['error'])) {
                $exception = new OutofboxAPIException($response_data['error']['message']);

                if (isset($response_data['error']['code'])) {
                    $exception->setErrorCode($response_data['error']['code']);
                }

                throw $exception;
            }
        }
    }

    protected function generateWsseHeader()
    {
        $nonce = hash('sha512', uniqid('', true));
        $created = date('c');
        $digest = base64_encode(sha1(base64_decode($nonce) . $created . $this->token, true));

        return sprintf(
            'UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"',
            $this->username,
            $digest,
            $nonce,
            $created
        );
    }

    /**
     * @param Client $httpClient
     * @return $this
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param Client|array|null $httpClientOrOptions
     * @return Client
     */
    protected static function createHttpClient($httpClientOrOptions = null)
    {
        $httpClient = null;
        if ($httpClientOrOptions instanceof Client) {
            $httpClient = $httpClientOrOptions;
        } else if (is_array($httpClientOrOptions)) {
            $httpClient = new Client($httpClientOrOptions);
        } else {
            $httpClient = new Client(self::$default_http_client_options);
        }

        return $httpClient;
    }
}
