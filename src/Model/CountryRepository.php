<?php

namespace App\Model;

use PDO;
use PDOException;

class CountryRepository
{
    private ?PDO $pdo;
    private string $baseUrl;

    public function __construct()
    {
        $dbConfig = require __DIR__ . '/../Config/db.php';
        $appConfig = require __DIR__ . '/../Config/app.php';
        $this->baseUrl = $appConfig['baseUrl'];

        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";

        try {
            $this->pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Could not connect to the database: " . $e->getMessage());
        }
    }

    /**
     * Знаходить усі країни для списку.
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT alias, name_common, name_official FROM countries ORDER BY name_common ASC");
        $countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($country) {
            return [
                'alias' => $country['alias'],
                'name' => [
                    'common' => $country['name_common'],
                    'official' => $country['name_official'],
                ]
            ];
        }, $countries);
    }

    /**
     * Знаходить країну за її псевдонімом (alias).
     * @param string $alias
     * @return array|null
     */
    public function findByAlias(string $alias): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM countries WHERE alias = :alias");
        $stmt->execute(['alias' => $alias]);
        $country = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$country) {
            return null;
        }

        $country['timezones'] = json_decode($country['timezones']);
        $country['languages'] = json_decode($country['languages'], true);
        $country['currencies'] = json_decode($country['currencies'], true);

        return [
            "alias" => $country['alias'],
            "name" => [
                "common" => $country['name_common'],
                "official" => $country['name_official']
            ],
            "capital" => [$country['capital']],
            "region" => $country['region'],
            "subregion" => $country['subregion'],
            "population" => (int)$country['population'],
            "area" => (float)$country['area'],
            "timezones" => $country['timezones'],
            "languages" => $country['languages'],
            "currencies" => $country['currencies'],
            "flags" => [
                "png" => $this->baseUrl . $country['flag_png'],
                "svg" => $this->baseUrl . $country['flag_svg']
            ]
        ];
    }
}

