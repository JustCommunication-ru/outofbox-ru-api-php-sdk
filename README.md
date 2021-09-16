# Outofbox.ru API PHP SDK

[![Latest Stable Version](https://poser.pugx.org/justcommunication-ru/outofbox-ru-api-php-sdk/v)](//packagist.org/packages/justcommunication-ru/outofbox-ru-api-php-sdk)
[![Latest Unstable Version](http://poser.pugx.org/justcommunication-ru/outofbox-ru-api-php-sdk/v/unstable)](https://packagist.org/packages/justcommunication-ru/outofbox-ru-api-php-sdk)
[![Total Downloads](https://poser.pugx.org/justcommunication-ru/outofbox-ru-api-php-sdk/downloads)](//packagist.org/packages/justcommunication-ru/outofbox-ru-api-php-sdk)
[![License](http://poser.pugx.org/justcommunication-ru/outofbox-ru-api-php-sdk/license)](https://packagist.org/packages/justcommunication-ru/outofbox-ru-api-php-sdk) 
[![composer.lock](http://poser.pugx.org/justcommunication-ru/outofbox-ru-api-php-sdk/composerlock)](https://packagist.org/packages/justcommunication-ru/outofbox-ru-api-php-sdk)

PHP SDK для сайтов и интернет-магазинов на платформе outofbox.ru

## Установка

`composer require justcommunication-ru/outofbox-ru-api-php-sdk`

## Использование

```php
$client = new OutofboxAPIClient('https://domain.ru', 'username', 'token');
```
`https://domain.ru` – домен вашего сайта на платформе outofbox.ru

`email` — имя пользователя или email. Уровень доступа аккаунта должен быть не менее `Сотрудник`

`token` — аутентификационный токен

## Методы

### Токен авторизации

```php
$client = new OutofboxAPIClient('https://domain.ru', 'username', ''); // обязательно передать пустой token

$token = OutofboxAPIClient->getAuthToken($password);

var_dump($token);
```

`$password` – пароль пользователя

### Список позиций каталога

```php

$request = new ProductsListRequest();

$request
    ->setImagesSizes([
        'thumbnail' => [
            'fs' => 'ofb-320-240'
        ]
    ])
;

$response = $client->sendProductsListRequest($request);

foreach ($response->getProducts() as $product) {
    echo $product->getTitle() . ' ' . $product->getFieldValue('Марка') . ' ' . $product->getFieldValue('Модель') . "\n";
    if ($product->withImages()) {
        echo $product-getImages()[0]->getUrl('thumbnail') . "\n";
    }
}

```

### Просмотр позиции каталога

```php
$request = ProductViewRequest::withProductID($id);
$request
    ->addImageSize('medium', [
        'fs' => 'ofb-640'
    ])
;

$response = $client->sendProductViewRequest($request);
$product = $response->getProduct();

echo $product->getTitle() . ' ' . $product->getFieldValue('Марка') . ' ' . $product->getFieldValue('Модель') . "\n";
if ($product->withImages()) {
    echo $product-getImages()[0]->getUrl('medium') . "\n";
}
```

## Обработка ошибок

При ошибке будет сгенерировано исключение `OutofboxAPIException`

```php
try {
    $client->sendProductViewRequest(ProductViewRequest::withProductID($id));
} catch (OutofboxAPIException $e) {
    $logger->error('Outofbox ERROR: ' . $e->getMessage());
}
```

## Настройка HTTP клиента

### Способ №1: передача массива параметров

```php
$client = new OutofboxAPIClient('https://domain.ru', 'email', 'token', [
    'proxy' => 'tcp://localhost:8125',
    'timeout' => 6,
    'connect_timeout' => 4
]);
```

Список доступных параметров: https://docs.guzzlephp.org/en/stable/request-options.html

### Способ №2: передача своего `\GuzzleHttp\Client`

Настройте своего http клиента:

```php
// Http клиент с логгированием всех запросов

$stack = HandlerStack::create();
$stack->push(Middleware::log($logger, new MessageFormatter(MessageFormatter::DEBUG)));

$httpClient = new \GuzzleHttp\Client([
    'handler' => $stack,
    'timeout' => 6
]);
```

и передайте его аргументом конструктора:

```php
$client = new OutofboxAPIClient('https://domain.ru', 'email', 'token', $httpClient);
```

либо сеттером:

```php
$client = new OutofboxAPIClient('https://domain.ru', 'email', 'token');
$client->setHttpClient($httpClient);
```

## Логирование

В `$client` можно передать свой `Psr\Logger`.

```php
$client->setLogger($someLogger);
```

По-умолчанию, логирование отключено.

## Тесты

Запустить тесты можно командой:

`vendor/bin/phpunit`