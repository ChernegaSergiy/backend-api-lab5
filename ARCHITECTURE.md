# Архітектура back-end для лабораторної роботи № 5

## 1. Контракт API (JSON-відповіді)

### `GET /mycountries/v1.1/getcountrieslist`
Повертає масив країн для випадаючого списку:

```json
[
  {
    "alias": "ukraine",
    "name": {
      "common": "Ukraine",
      "official": "Ukraine"
    }
  },
  {
    "alias": "poland",
    "name": {
      "common": "Poland",
      "official": "Republic of Poland"
    }
  }
]
```

---

### `GET /mycountries/v1.1/getcountry/:alias`
Повертає детальну інформацію про країну:

```json
{
  "alias": "ukraine",
  "name": {
    "common": "Ukraine",
    "official": "Ukraine"
  },
  "capital": ["Kyiv"],
  "region": "Europe",
  "subregion": "Eastern Europe",
  "population": 44130000,
  "area": 603628,
  "timezones": ["UTC+02:00"],
  "languages": {
    "ukr": "Ukrainian"
  },
  "currencies": {
    "UAH": {
      "name": "Ukrainian hryvnia",
      "symbol": "₴"
    }
  },
  "flags": {
    "png": "http://localhost/mycountries/assets/flags/ua.png",
    "svg": "http://localhost/mycountries/assets/flags/ua.svg"
  }
}
```

---

### (Опційно) `GET /mycountries/v1.1/getcity/:alias`

```json
{
  "alias": "kyiv",
  "name": "Kyiv",
  "country_alias": "ukraine",
  "population": 2967000,
  "area": 839,
  "timezone": "UTC+02:00"
}
```

---

## 2. Схема бази даних

### Таблиця `countries`

```sql
CREATE TABLE countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alias VARCHAR(64) NOT NULL UNIQUE,
    name_common VARCHAR(255) NOT NULL,
    name_official VARCHAR(255) NOT NULL,
    capital VARCHAR(255),
    region VARCHAR(128),
    subregion VARCHAR(128),
    population BIGINT,
    area DOUBLE,
    timezones TEXT,
    languages TEXT,
    currencies TEXT,
    flag_png VARCHAR(255),
    flag_svg VARCHAR(255)
);
```

---

### Таблиця `cities` (опційно)

```sql
CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alias VARCHAR(64) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    country_id INT NOT NULL,
    population BIGINT,
    area DOUBLE,
    timezone VARCHAR(64),
    FOREIGN KEY (country_id) REFERENCES countries(id)
);
```

---

## 3. Пропонована структура проєкту (MVC-lite)

```
mycountries/
├── public/
│   └── index.php
├── src/
│   ├── Config/
│   │   └── db.php
│   ├── Router/
│   │   └── Router.php
│   ├── Controller/
│   │   ├── CountryController.php
│   │   └── CityController.php
│   └── Model/
│       ├── CountryRepository.php
│       └── CityRepository.php
└── sql/
    ├── schema.sql
    └── seed.sql
```

---

## 4. Мінімальна точка входу (public/index.php)

```php
<?php
require __DIR__ . '/../src/Config/db.php';
require __DIR__ . '/../src/Router/Router.php';
require __DIR__ . '/../src/Controller/CountryController.php';

use App\Router\Router;
use App\Controller\CountryController;

$router = new Router();

$router->get('/mycountries/v1.1/getcountrieslist', [CountryController::class, 'list']);
$router->get('/mycountries/v1.1/getcountry/{alias}', [CountryController::class, 'show']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
```

---

## 5. Мінімальні зміни у JavaScript (взято з ЛР4)

```javascript
// Було:
const API_ALL = 'https://restcountries.com/v3.1/all';
const API_COUNTRY = 'https://restcountries.com/v3.1/name/';

// Стало:
const API_BASE = 'http://localhost/mycountries/v1.1/';
const API_ALL = API_BASE + 'getcountrieslist';
const API_COUNTRY = API_BASE + 'getcountry/';

// Інше — залишається майже без змін,
// якщо структура JSON така сама, як у RESTCountries.
```
