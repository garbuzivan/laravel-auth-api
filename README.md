# Laravel Auth Api - библиотека для получения и генерации токена различными методами

## Установка

`composer require garbuzivan/laravel-auth-api`

<p>и опубликовать конфигурацию</p>

`php artisan vendor:publish  --force --provider="GarbuzIvan\LaravelAuthApi\LaravelAuthApiServiceProvider" --tag="config"`


<p>config/app.php в блок 'providers' => []</p>

`GarbuzIvan\LaravelAuthApi\LaravelAuthApiServiceProvider::class,`

### .env
Функция отправки сообщений на EMAIL использует настройки .env Laravel блок MAIL

## Особенности

<p>Пакет использует систему очередей Laravel, пример запуска на исполнение :</p> 

`php artisan queue:work`

<p>Тестировалось с настройками .env</p>

`QUEUE_CONNECTION=database`

## Пример использования

<pre>
        $LaravelAuthApi = new LaravelAuthApi();
        $result = $LaravelAuthApi->auth(request()->all());
        if ($result->isSuccess()) {
            $status = $result->getStatus();
            // Если $status = null ожидаем Token
            if(is_null($status)){
                return $this->sendJson(['token' => $result->getToken()]);
            } else {
                // если статус массив, ожидаем получение данных с заполнением параметров у которых значение false
                return $this->sendJson($status);
            }
        } else {
            return $this->sendError($result->getError(), 403);
        }
</pre>
