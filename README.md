# Laravel Auth Api - библиотека для получения и генерации токена различными методами

## Установка

`composer require garbuzivan/laravel-auth-api`

<p>и опубликовать конфигурацию</p>

`php artisan vendor:publish  --force --provider="GarbuzIvan\LaravelAuthApi\LaravelAuthApiServiceProvider" --tag="config"`

## Пример использования

<pre>
$LaravelAuthApi = new LaravelAuthApi();
$result = $LaravelAuthApi->auth();
if($result->isSuccess()){
    dd($result->getToken());
]} else {
    dd($result->getError());
}
</pre>
