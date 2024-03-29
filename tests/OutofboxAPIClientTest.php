<?php
namespace Tests;

use GuzzleHttp\Client;
use Outofbox\OutofboxSDK\OutofboxAPIClient;
use PHPUnit\Framework\TestCase;

class OutofboxAPIClientTest extends TestCase
{
    public function testCallUndefinedMethod()
    {
        $client = new OutofboxAPIClient('http://user.newoutofbox.ru', 'username', 'token');

        $this->expectException(\BadMethodCallException::class);
        $client->callSomeUndefinedRequest(new \Outofbox\OutofboxSDK\API\ProductsListRequest());
    }

    public function testCreateHttpClientWithDefault()
    {
        $client = new OutofboxAPIClient('http://user.newoutofbox.ru', 'username', 'token');

        $this->assertEquals(10, $client->getHttpClient()->getConfig('timeout'));
    }

    public function testCreateHttpClientWithArray()
    {
        $client = new OutofboxAPIClient('http://user.newoutofbox.ru', 'username', 'token', [
            'timeout' => 20
        ]);

        $this->assertEquals(20, $client->getHttpClient()->getConfig('timeout'));
    }

    public function testCreateHttpClientWithCustomHttpClient()
    {
        $httpClient = new Client([
            'timeout' => 15
        ]);

        $client = new OutofboxAPIClient('http://user.newoutofbox.ru', 'username', 'token', $httpClient);
        $this->assertEquals(15, $client->getHttpClient()->getConfig('timeout'));

        $httpClient = new Client([
            'timeout' => 25
        ]);

        $client = new OutofboxAPIClient('http://user.newoutofbox.ru', 'username', 'token');
        $this->assertEquals(10, $client->getHttpClient()->getConfig('timeout'));

        $client->setHttpClient($httpClient);
        $this->assertEquals(25, $client->getHttpClient()->getConfig('timeout'));
    }
}
