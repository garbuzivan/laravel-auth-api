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
        if (!$result->isSuccess()) {
            return $this->sendError($result->getError(), 403);
        }
        $status = $result->getStatus();
        // Если $status = null ожидаем Token
        if(is_null($status)){
            return $this->sendJson(['token' => $result->getToken()]);
        } else {
            // если статус массив, ожидаем получение данных с заполнением параметров у которых значение false
            return $this->sendJson($status);
        }
</pre>


## Конфигурация пакета

<p><b>pipes</b> - массив классов от AbstractPipes с различными методами получения токена</p>

<p><b>new_token_after_auth</b> - если false то при авторизации, в случае ранее созданного токена, новый не будет генерироваться, а вернется старый</p>

<p><b>length_token</b> - длина нового токена</p>

<p><b>code_email</b> - правила генерации одноразового пароля отправляемого на email. charset - массив возможных символов, length - длина пароля.</p>

<p><b>view_mail</b> - view шаблон для отправки письма с одноразовым паролем на email</p>

### SMS настройки

<p>Реализовано с помощью пакета <a href="https://github.com/artem-prozorov/data-locker" target="_blank">https://github.com/artem-prozorov/data-locker</a></p>
