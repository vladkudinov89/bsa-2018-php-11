# Binary Studio Academy 2018

## PHP Testing

### Цель

Ознакомиться с основными видами автоматизированного тестирования.
Научиться писать модульные и функциональные тесты при помощи фреймоврка PHPUnit.
Научиться тестировать приложение в фреймворке Laravel.

### Задание

Прежде всего вам необходимо реализовать следующие интерфейсы:

* [Сущности](app/Entity/Contracts):
    * [App\Entity\Contracts\Currency](app/Entity/Contracts/Currency.php)
    * [App\Entity\Contracts\CurrencyType](app/Entity/Contracts/CurrencyType.php)
    * [App\Entity\Contracts\Lot](app/Entity/Contracts/Lot.php)
    * [App\Entity\Contracts\Trade](app/Entity/Contracts/Trade.php)
    * [App\Entity\Contracts\Wallet](app/Entity/Contracts/Wallet.php)
* [Репозитории](app/Repository/Contracts)
    * [App\Repository\Contracts\CurrencyRepository](app/Repository/Contracts/CurrencyRepository.php)
    * [App\Repository\Contracts\CurrencyTypeRepository](app/Repository/Contracts/CurrencyTypeRepository.php)
    * [App\Repository\Contracts\LotRepository](app/Repository/Contracts/LotRepository.php)
    * [App\Repository\Contracts\TradeRepository](app/Repository/Contracts/TradeRepository.php)
    * [App\Repository\Contracts\WalletRepository](app/Repository/Contracts/WalletRepository.php)
* [Сервисы](app/Service/Contracts)
    * [App\Service\Contracts\CurrencyTypeService](app/Service/Contracts/CurrencyTypeService.php)
    * [App\Service\Contracts\MarketService](app/Service/Contracts/MarketService.php)
    * [App\Service\Contracts\WalletService](app/Service/Contracts/WalletService.php)

А также вспомогательные реквесты и респонсы, необходимые для работы сервисов.<br>
Сервисы и репозитории должны быть зарегистрированы как сервис контейнеры в виде интерфейса на реализацию.<br>
Для сущностей вам необходимо создать модели и миграции для базы данных.<br>
Разрешается добавлять вспомогательные методы в сервисы и репозитории, если это необходимо.<br>
Для работы с почтой используйте [драйвер для разработки](https://laravel.com/docs/5.6/mail#mail-and-local-development).

### Задание #1

Вам необходимо написать модульные тесты для методов сервисов.<br>
* [MarketService](app/Service/Contracts/MarketService.php)
    * `addLot` - выставление лота продажы валюты. Метод должен соответствовать следующим ограничениям:
        * Пользователь не может иметь более одной активной сессии продажи одной и той же валюты
        * Дата закрытия сессии не может быть меньше чем дата открытия
        * Цена лота не может быть отрицательной
        * В случае успешного выполнения должен быть добавлен лот
    * `buyLot` - покупка валюты из лота. Метод должен соответствовать следующим ограничениям:
        * Из кошелька продавца должна быть извлечена купленная валюта
        * В кошелек покупателя должна быть добавлена валюта
        * Пользователь не может покупать собственную валютту
        * Пользователь не может покупать больше валюты чем содержит лот
        * Пользователь не может купить меньше одной единицы валюты
        * Пользователь не может купить валюты из закрытого лота 
        * После успешного выполнения должна быть добавлена сделка (`Trade`)
        * После успешного выполнения на почту продавца должно отправиться электронное письмо
    * `getLot` - возвращает информацию о лоте по идентификатору. Метод должен соответствовать следующим ограничениям:
        * Если запрашиваемого лота не существует должно выбрасываться исключение.
        * Количество валюты должно соответствовать количеству валюты в кошельке пользователя.
        * Даты закрытия и открытия должны быть представлены строкой в формате: `yyyy/mm/dd hh:mm:ss`
        * Цена за единицу валюты должна быть в формате: `00,00`
    * `getLotList` - возвращает массив объектов типа `LotResponse`.
* [WalletService](app/Service/Contracts/WalletService.php)
    * `addWallet` - добавляет кошелек пользователю. Пользователь не может иметь более одного кошелька.
    * `addCurrency` - добавляет единицы заданной валюты в кошелек пользователя. Пользователь может иметь более одной записи с одной валютой в кошельке.
    * `takeCurrency` - добавлет отрицательное количество валюты в кошелек пользователя. Значение количества валюты не должно превышать количество валюты в кошельке пользователя.
* [CurrencyTypeService](app/Service/Contracts/CurrencyTypeService.php)
    * `addCurrencyType` - добавляет валюту в справочник. В справочнике не должно быть валюты с одинаковым именем.

В этом задании вы должны использовать создание моков, стабов, а также использовать ассершены, предоставляемые PHPUnit и Laravel.
Модульные тесты размещаются в директории `tests\Unit`.

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

Цена сделки должна зависеть от курса выбранной валюты.

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

Класс для тестирования API нужно разместить в `/tests/Feature/`.

### Задание #3

Используя Dusk написать UI тест проверки формы изменения курса валюты.<br>
Создайте страницу с формой изменения курса валют по маршруту `/currency/rate`.<br>
Форма должна состоять из выпадающего списка валют, поля изменения курса и кнопки с надписью "change".<br>
Курс валюты должен быть числом и не может быть отрицательным. <br>
В случае успешного изменения курса должно выводиться сообщение: "Rate has changed successfully!".<br>
В случае не удачного изменения должна быть надпись: "Sorry, error has occurred: &lt;error text&gt;",<br>
где &lt;error text&gt; - текст ошибки.<br>
Необходимо протестировать отображение формы и вывод соответствующих сообщений.

### Установка

### Проверка


