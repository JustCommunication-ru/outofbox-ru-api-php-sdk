# Outofbox.ru API PHP SDK

[![Latest Stable Version](https://poser.pugx.org/justcommunication-ru/outofbox-ru-api-php-sdk/v)](//packagist.org/packages/justcommunication-ru/outofbox-ru-api-php-sdk)
[![Latest Unstable Version](http://poser.pugx.org/justcommunication-ru/outofbox-ru-api-php-sdk/v/unstable)](https://packagist.org/packages/justcommunication-ru/outofbox-ru-api-php-sdk)
[![Total Downloads](https://poser.pugx.org/justcommunication-ru/outofbox-ru-api-php-sdk/downloads)](//packagist.org/packages/justcommunication-ru/outofbox-ru-api-php-sdk)
[![License](http://poser.pugx.org/justcommunication-ru/outofbox-ru-api-php-sdk/license)](https://packagist.org/packages/justcommunication-ru/outofbox-ru-api-php-sdk) 

PHP SDK для сайтов и интернет-магазинов на платформе outofbox.ru

- [Установка](#установка)
- [Использование](#использование)
- [Методы](#методы)
  - [Токен авторизации](#токен-авторизации)
  - [Список позиций каталога](#список-позиций-каталога)
  - [Просмотр позиции каталога](#просмотр-позиции-каталога)
  - [Список категорий товаров](#список-категорий-товаров)
  - [Список филиалов](#список-филиалов)
  - [Заказы/Заявки](#заказызаявки)
    - [Создание заказа/заявки](#создание-заказазаявки)
    - [Информация о заказе/заявке](#информация-о-заказезаявке)
- [Обработка ошибок](#обработка-ошибок)
- [Настройка HTTP клиента](#настройка-http-клиента)
- [Логирование](#логирование)
- [Тесты](#тесты)

## Установка

`composer require justcommunication-ru/outofbox-ru-api-php-sdk`

## Использование

```php
$client = new OutofboxAPIClient('https://domain.ru', 'email', 'token');
```
`https://domain.ru` – домен вашего сайта на платформе outofbox.ru

`email` — имя пользователя или email. Уровень доступа аккаунта должен быть не менее `Сотрудник`

`token` — аутентификационный токен

## Методы

### Токен авторизации

Данный метод поможет получить токен авторизации пользователя по его паролю. Токен не ограничен во времени и может
поменяться только в случае смены пароля пользователя.

```php
$client = new OutofboxAPIClient('https://domain.ru', 'username', ''); // обязательно передать пустой token

$token = $client->getAuthToken($password);

var_dump($token);
```

`$password` – пароль пользователя

Внимание! Данный метод не предназначен для запроса на боевом окружении!
Предполагается, что если вам не известен токен пользователя, то необходимо его запросить и далее работать
исключительно с токеном авторизации. Не храните пароль пользователя в открытых источниках!

Если существует риск утечки токена, то рекомендуется поменять пароль пользователя и запросить токен еще раз.

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

#### Наличие на складах (Если подключен Outofbox.Склад)

```php
$request = new ProductsListRequest();
$request
    ->setInStock(true) // только в наличии на любом складе
    ->setInStock(false) // только НЕ в наличии на любом складе
    
    ->setStock(5643) // только в наличии в филиале с номером 5643
    ->setStocks([ 5643, 5644 ]) // только если позиция есть в наличии в филиалах 5643 или 5644
;
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

## Список категорий товаров

### Верхний уровень категорий:
```php
$request = new CategoriesListRequest();
$response = $client->sendCategoriesListRequest($request);

foreach ($response->getCategories() as $category) {
    echo $category->getFullTitle(' > ') . "\n";
}
```

### Подкатегории:
```php
$request = new CategoriesListRequest(123); // список категорий для подкатегории с идентификатором 123
```
или

```php
$request = new CategoriesListRequest();
$request->setParentId(123);
```

```php
$response = $client->sendCategoriesListRequest($request);

foreach ($response->getCategories() as $category) {
    echo $category->getFullTitle(' > ') . "\n";
}
```

Важно! Данный метод не подходит для выбора всего дерева подкатегорий рекурсивными вызовами!
Вместо этого надо использовать метод, который может вернуть сразу все дерево (@todo)

## Список филиалов

```php
$request = new StoresListRequest();
$response = $client->sendStoresListRequest($request);

foreach ($response->getStores() as $store) {
    echo $store->getName() . ' (№' . $store->getId() . ')' . "\n";
}
```

## Заказы/Заявки

- [Создание заказа/заявки](#создание-заказазаявки)
- [Информация о заказе/заявке](#информация-о-заказезаявке)

### Создание заказа/заявки

```php
$request = new CreateShopOrderRequest();

$request
    ->setPhoneNumber('89688888888') // номер телефона
    ->setStoreId(123) // идентификатор филиала/склада
    // состав заказа
    ->setProducts([
        ProductShopOrderItem::create(1271231, 1), // Позиция с id = 1271231, 1 шт.
        ProductShopOrderItem::create(1271232, 2)  // Позиция с id = 1271232, 2 шт.
    ])
;

// Можно добавить еще один товар в список
$request->addProduct(ProductShopOrderItem::create(1271233, 3));

$response = $client->sendCreateShopOrderRequest($request);

echo 'Заказ создан, его номер: ' . $response->getShopOrder()->getNumber();
```

@todo: описать все доступные поля заказа (адреса доставки, данные клиента и т. д.)

### Информация о заказе/заявке

```php
use Outofbox\OutofboxSDK\API\ShopOrders\GetShopOrderRequest;
use Outofbox\OutofboxSDK\OutofboxAPIClient;

$client = new OutofboxAPIClient($domain, $username, $api_token);

// через объект запроса
$request = new GetShopOrderRequest();
$request->setOrderNumber('8189-071122');

$response = $client->sendGetShopOrderRequest($request);

$shopOrder = $response->getShopOrder();

// либо короче
$shopOrder = $client->getShopOrder('8189-071122');

$shopOrder->number; // номер заказа
$shopOrder->delivery_price; // стоимость доставки

if ($shopOrder->status) {
    $shopOrder->status->id; // идентификатор статуса заказа
    $shopOrder->status->value; // наименование статуса заказа
} else {
    // статус "Новый"
}

if ($shopOrder->deliveryMethod) {
    $shopOrder->deliveryMethod->id; // идентификатор способа доставки
    $shopOrder->deliveryMethod->value; // наименование способа доставки
}

if ($shopOrder->paymentMethod) {
    $shopOrder->paymentMethod->id; // идентификатор способа оплаты
    $shopOrder->paymentMethod->value; // наименование способа оплаты
}

// позиции заказа
foreach ($shopOrder->items as $shopOrderItem) {
    $shopOrderItem->id; // идентификатор позиции
    $shopOrderItem->title; // наименование позиции
    $shopOrderItem->price; // стоимость единицы позиции
    $shopOrderItem->quantity; // количество
    $shopOrderItem->amount; // общая стоимость
    $shopOrderItem->item_weight; // вес одной позиции
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