# Binary Studio Academy 2018

## PHP Testing

### Цель

Ознакомиться с основными видами автоматизированного тестирования.
Научиться писать модульные и функциональные тесты при помощи фреймоврка PHPUnit.
Научиться тестировать приложение в фреймворке Laravel.

### Задание

Необходимо протестировать функции работы онлайн рынка криптовалют.
Для начала необходимо создать миграции моделей, описание которых представлено в интерфейсах: 

- `App\Entity\Contracts\ICurrency` - модель валюты
- `App\Entity\Contracts\IRate` - модель курса валюты
- `App\Entity\Contracts\ITrade` - модель сделки

Реализовать интерфейсы репозиториев моделей:

- `App\Repository\Contracts\ICurrencyRepository`
- `App\Repository\Contracts\IRateRepository`
- `App\Repository\Contracts\ITradeRepository`

Реализовать интерфейсы сервисов:

- `App\Service\Contracts\ICurrencyService`
- `App\Service\Contracts\IMarketService`

### Задание #1

Вам необходимо написать модульные тесты для методов сервисов:
`App\Service\Contracts\ICurrencyService::getRiseOfRate` - возращает массив величин изменения курса валют `ICurrency` в процентах по отношению к предыдущей.<br>
Допустим, курс Bitcoin колеблеться в следующей последовательности `6399`, `6402`, `6320`, `6340`, `6342`, значит метод должен вернуть `[ 0.046, -1.28, 0.316, 0.0315 ]`.<br>

`App\Service\Contracts\ICurrencyService::getTheMostExpensiveCurrency` - возращает валюту `ICurrency` с самым высоким курсом.

`App\Service\Contracts\IMarketService::getTheMostProfitableTrade` - возращает самую выгодную активную сделку `ITrade`. 
Выгодной будем считать сделку с максимальным количеством денежных единиц по самому низкому курсу.

Модульные тесты необходимо разместить в директории `tests\Unit`.

### Задание #2

Используя инструменты Laravel для тестирования API протестировать работу с рынком криптовалют.<br>

Для начала вам необходимо реализовать end points для работы со сделками:

- Создание сделки<br>
`POST /api/v1/trades` <br>
`Content-type: application/json`<br>
`Status code: 201`<br>
```
{ 
    "currency_id": <int>,
    "amount": <float>
}
```
- Изменение статуса сделки<br>
`PUT /api/v1/trades/{id}`<br> 
`Content-type: application/json`<br>
`Status code: 200`<br>
```
{ 
    "status": <string>
}
```
- Вывод списка сделок<br>
`GET /api/v1/trades`<br> 
`Content-type: application/json`<br> 
`Status code: 200`<br>
```
[
    { 
        "user": <string>, // имя пользователя сделки
        "currency": <string>, // имя валюты
        "amount": <float>, // количество продаваемых единиц
        "rate": <float>, // курс валюты
        "total_price": <float>, // цена с учетом курса и количества
        "status": <string> // статус сделки
    },
    ...
]
```

Ограничения:
- Создавать сделки могут только авторизованные пользователи
- Один пользователь может иметь только одну активную сделку для каждой валюты
- Удаленная и выполненные сделки не могут стать активными
- Выполненная сделка не может быть удалена
- Удалять сделку может только ее владелец
- Владелец не может изменить статус сделки на выполненная

Если выполняется действие не подходящее под ограничения должен возвращаться следующий ответ:<br>
`Content-type: application/json`<br>
`Status code: 400`<br>
```
{ 
    error: <string>
}
```

### Задание #3

Используя Dusk написать UI тест проверки формы добавления валюты.<br>
Создайте страницу с формой добавления валюты с маршрутом `/currency/add`.

### Установка

### Проверка


