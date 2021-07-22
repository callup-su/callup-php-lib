# Call-up

PHP библиотека для взаимодействия с сервисом [Call-Password](https://git.zonatelecom.ru/z_micro/call-password).

Содержание
- [Входные данные](#входные-данные)
- [Примеры](#примеры)
- [Тестирование](#тестирование)

## Входные данные

Объект `CallUp` принимает 3 параметра

- `params` - массив параметров
- `dir` - директория файла конфигураций
- `filename` - название файла конфигурации

```php
new CallUp($params, $dir, $filename);
```

> ВАЖНО: если не указан массив `params`, то данные берутся из файла. Если параметры файла не указаны, то данные берутся по умолчанию от корня проекта из файла `.env`

## Примеры

Для генерации кода необходимо использовать функцию `verify(string $phone)`

где

`$phone` - номер телефона, на который необходимо отправить код верификации

```php
try {
  $callUp = new CallUp();
  $r = $callUp->verify($phone);
  if ($r->hasErrors() === true) {
    throw new Exception($r->getErrors());
  }
} catch (Exception $e) {
  // some actions after catching the error
}
```

Для авторизации используется функция `signIn(string $id, string $code)`

где

`$id` - идентификатор заказа

`$code` - 4-х значный код

```php
try {
  $callUp = new CallUp();
  $r = $callUp->signIn($id, $code);
  if ($r->hasErrors() === true) {
    throw new Exception($r->getErrors());
  }
  if ($r->getData()['success'] === true) {
    // actions after successful authorization
  };
} catch (Exception $e) {
  // some actions after catching the error
}
```

## Тестирование

Для тестирования используется библиотека [PHPUnit 9](https://phpunit.de/getting-started/phpunit-9.html)

Для запуска `unit-тестов` необходимо выполнить команду

```bash
> ./vendor/bin/phpunit tests
```

Для запуска отдельного `unit-теста` необходимо выполнить команду

```bash
> ./vendor/bin/phpunit tests ./tests/unit/path/to/file.php
```