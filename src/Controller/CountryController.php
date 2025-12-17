<?php

namespace App\Controller;

class CountryController
{
    /**
     * Статичний список країн для демо-роутингу без БД.
     * Імітує дані у форматі, який очікує front-end.
     */
    private array $countries = [
        [
            'alias' => 'ukraine',
            'name' => [
                'common' => 'Ukraine',
                'official' => 'Ukraine',
            ],
            'capital' => ['Kyiv'],
            'region' => 'Europe',
            'subregion' => 'Eastern Europe',
            'population' => 44130000,
            'area' => 603628,
            'timezones' => ['UTC+02:00'],
            'languages' => ['ukr' => 'Ukrainian'],
            'currencies' => ['UAH' => ['name' => 'Ukrainian hryvnia', 'symbol' => '₴']],
            'flags' => [
                'png' => '/assets/flags/ua.png',
                'svg' => '/assets/flags/ua.svg',
            ],
        ],
        [
            'alias' => 'poland',
            'name' => [
                'common' => 'Poland',
                'official' => 'Republic of Poland',
            ],
            'capital' => ['Warsaw'],
            'region' => 'Europe',
            'subregion' => 'Central Europe',
            'population' => 38386000,
            'area' => 312679,
            'timezones' => ['UTC+01:00'],
            'languages' => ['pol' => 'Polish'],
            'currencies' => ['PLN' => ['name' => 'Polish złoty', 'symbol' => 'zł']],
            'flags' => [
                'png' => '/assets/flags/pl.png',
                'svg' => '/assets/flags/pl.svg',
            ],
        ],
    ];

    /**
     * Повертає список країн (тільки alias та назви).
     */
    public function list(): void
    {
        $list = array_map(function ($country) {
            return [
                'alias' => $country['alias'],
                'name' => $country['name'],
            ];
        }, $this->countries);

        http_response_code(200);
        echo json_encode($list);
    }

    /**
     * Повертає деталі конкретної країни за alias.
     */
    public function show(string $alias): void
    {
        foreach ($this->countries as $country) {
            if ($country['alias'] === $alias) {
                http_response_code(200);
                echo json_encode($country);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['message' => 'Country not found']);
    }
}

