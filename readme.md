# Binary Studio Academy 2018

## PHP Testing

### Цель

Ознакомиться с основными видами автоматизированного тестирования.
Научиться писать модульные и функциональные тесты при помощи фреймоврка PHPUnit.
Научиться тестировать приложение в фреймворке Laravel.

### Установка

<b>Репозиторий форкать нельзя!</b>

```
git clone <link to repositry>
cd <repository_name>
cp .env.example .env
cp .env.example .env.dusk.local
composer install
php artisan key:generate
git checkout -b develop
```

После клонирования репозитория создайте ветку `develop` и всю разработку ведите в этой ветви.
Также рекомендуется использовать Homestead для поднятия приложения.

Для работы dusk в среде Homestead дополнительно может потребоваться выполнение следующих действий:

1. Зайдите на виртуальную машину через ssh из папки, где установлен Homestead
```
vagrant ssh
```
2. Выполните следующие команды
```
wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | sudo apt-key add -

sudo sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google-chrome.list'

sudo apt-get update && sudo apt-get install -y google-chrome-stable

sudo apt-get install -y xvfb
```

3. Затем выполните: 
```
Xvfb :0 -screen 0 1280x960x24 &
```

4. Теперь можно запускать тесты:
```
php artisan dusk
```

- см. https://github.com/laravel/dusk/issues/50#issuecomment-275155974

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

А также вспомогательные [реквесты](app/Request/Contracts) и [респонс](app/Response/Contracts), необходимые для работы сервисов.<br>
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
    * `takeCurrency` - сокращает количество валюты в кошелек пользователя. Значение количества валюты не должно превышать количество валюты в кошельке пользователя.
* [CurrencyTypeService](app/Service/Contracts/CurrencyTypeService.php)
    * `addCurrencyType` - добавляет валюту в справочник. В справочнике не должно быть валюты с одинаковым именем.

В этом задании вы должны использовать создание моков, стабов, а также использовать ассершены, предоставляемые PHPUnit и Laravel.
Модульные тесты размещаются в директории `tests\Unit`.

### Задание #2

Для выполнения этого задания вам необходимо использовать реализованные сервисы и средства работы с пользователями, предоставляемые фреймворком.

Для начала вам нужно добавить следующие роуты:
* Добавление лота<br>
`POST /api/v1/lots`<br>
`Content-type: application/json`<br>
`Status code: 201`<br>
`Request data: `<br>
```
{ 
    "currency_id": <int>,
    "date_time_open": <int>,
    "date_time_close": <int>,
    "price": <float>
}
```
* Покупка валюты<br>
`POST /api/v1/trades`<br>
`Content-type: application/json`<br>
`Status code: 201`<br>
`Request data: `<br>
```
{ 
    "lot_id": <int>,
    "amount": <float>
}
```
* Детальная информация о лоте<br>
`GET /api/v1/lots/{id}`<br>
`Content-type: application/json`<br>
`Status code: 200`<br>
`Response:`<br>
```
{
    "id": <int>,
    "user_name": <string>,
    "currency_name": <string>,
    "amount": <float>,
    "date_time_open": <string>,
    "date_time_close": <string>,
    "price": <string>
}
```
* Список всех лотов<br>
`GET /api/v1/lots`<br>
`Content-type: application/json`<br>
`Status code: 200`<br>
`Response:`<br>
```
[
    {
        "id": <int>,
        "user": <string>,
        "currency": <string>,
        "amount": <float>,
        "date_time_open": <string>,
        "date_time_close": <string>,
        "price": <string>
    },
    ...
]
```

Добавлять лоты и покупать валюту могут только зарегистрированные пользователи.<br>
В случае возникновения ошибки необходимо вернуть следующий ответ:<br>
`Content-type: application/json`<br>
`Status code: 400`<br>
```
{
    error: {
        message: <string>,
        status_code: <int>
    }
}
```

Если доступ запрещен, то код статуса ответа должен быть `403`.

Используя средства тестирования API и базы данных, предоставляемые фреймворком Laravel, написать тесты для тестирования роутов API. 
Для создания фейковых данных рекомендуется использовать [фабрики Laravel](https://laravel.com/docs/5.6/database-testing#generating-factories).

Класс для тестирования API нужно разместить в `/tests/Feature/`.

### Задание #3

Добавьте view с формой добавления лота по маршруту `/market/lots/add`.<br>
В случае успешного добавления лота должно выводиться сообщение: "Lot has been added successfully!".<br>
В случае не удачного добавления должна быть надпись: "Sorry, error has been occurred: &lt;error text&gt;",<br>
где &lt;error text&gt; - текст ошибки.<br>

Используя Dusk необходимо протестировать отображение формы и вывод соответствующих сообщений.<br>

### Прием решений

- Создайте репозиторий на github и запуште обе ветки `master` и `develop`.
- Установите в вашем github аккаунте [Travis CI](https://github.com/marketplace/travis-ci/plan/MDIyOk1hcmtldHBsYWNlTGlzdGluZ1BsYW43MA==#pricing-and-setup0).
- В репозитории перейдите в `Settings->Integrations&Services` и выберите в `Add service` Travis CI.
- Перейдите на сайт [travis-ci.org](https://travis-ci.org/), авторизуйтесь с вашего github аккаунта и включите ваш репозиторий.
- Пошлите пулл реквест из ветки `develop`, где должны быть все изменения, в ветку `master`, но не принимайте его.
- Оставьте ссылку на github репозиторий в личном кабинете.
