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



### Задание #3

### Установка

### Проверка


