# Outofbox.ru API PHP SDK

[![Latest Stable Version](https://poser.pugx.org/justcommunication-ru/outofbox-ru-api-php-sdk/v)](//packagist.org/packages/justcommunication-ru/outofbox-ru-api-php-sdk) [![Total Downloads](https://poser.pugx.org/justcommunication-ru/outofbox-ru-api-php-sdk/downloads)](//packagist.org/packages/justcommunication-ru/outofbox-ru-api-php-sdk) 

PHP SDK для сайтов и интернет-магазинов на платформе outofbox.ru

## Установка

`composer require justcommunication-ru/outofbox-ru-api-php-sdk`

## Использование

```php
$client = new OutofboxAPIClient('https://domain.ru', 'username', 'token');
```
`https://domain.ru` – домен вашего сайта на платформе outofbox.ru

`email` — имя пользователя или email. Уровень доступа аккаунта должен быть не менее `Сотрудник`

`token` — аутентификационный токен. 
Токен можно получить через метод `OutofboxAPIClient::getToken($domain, $email, $password)`

## Методы

### Токен авторизации

```php
$client = new OutofboxAPIClient('https://domain.ru', 'username', ''); // обязательно передать пустой token

$token = OutofboxAPIClient->getAuthToken('password');

var_dump($token);
```

`password` – пароль пользователя

### Список позиций каталога

```php
$response = $client->sendProductsListRequest(new ProductsListRequest());

foreach ($response->getProducts() as $product) {
    echo $product->getTitle() . ' ' . $product->getFieldValue('Марка') . ' ' . $product->getFieldValue('Модель') . "\n";
}

```

### Просмотр позиции каталога

Каналы всех профилей на страницу которых можно добавлять сообщения (включая собственные)

```php
$response = $client->sendProductViewRequest(ProductViewRequest::withProductID($id));
$product = $response->getProduct();

echo $product->getTitle() . ' ' . $product->getFieldValue('Марка') . ' ' . $product->getFieldValue('Модель') . "\n";
```

## Обработка ошибок

При ошибке будет сгенерировано исключение ```OutofboxAPIException```

```php
try {
    $client->sendMessageCreateRequest(MessageCreateRequest::withPlainText($profile_id, $channel_id, $text));
} catch (WiracleAPIException $e) {
    $logger->error('Wiracle ERROR: ' . $e->getMessage());
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