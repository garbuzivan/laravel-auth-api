# Laravel Auth Api - библиотека для получения и генерации токена различными методами

## Установка

`composer require garbuzivan/laravel-auth-api`

<p>и опубликовать конфигурацию</p>

`php artisan vendor:publish  --force --provider="GarbuzIvan\LaravelAuthApi\LaravelAuthApiServiceProvider" --tag="config"`


<p>config/app.php в блок 'providers' => []</p>

`GarbuzIvan\LaravelAuthApi\LaravelAuthApiServiceProvider::class,`

## Пример использования

<pre>
        $LaravelAuthApi = new LaravelAuthApi();
        $result = $LaravelAuthApi->auth(request()->all());
        if ($result->isSuccess()) {
            $status = $result->getStatus();
            // Если $status = null ожидаем токен
            if(is_null($status)){
                dd($result->getToken());
            } else {
                // если статус массив, ожидаем получение данных с заполнением параметров у которых значение false
                dd($status);
            }
        } else {
            dd($result->getError());
        }
</pre>
