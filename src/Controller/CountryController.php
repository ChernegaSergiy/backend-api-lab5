<?php

namespace App\Controller;

require_once __DIR__ . '/../Model/CountryRepository.php';

use App\Model\CountryRepository;

class CountryController
{
    private CountryRepository $countryRepository;

    public function __construct()
    {
        $this->countryRepository = new CountryRepository();
    }

    /**
     * Повертає список країн з бази даних.
     */
    public function list(): void
    {
        $data = $this->countryRepository->findAll();
        http_response_code(200);
        echo json_encode($data);
    }

    /**
     * Повертає інформацію про країну з бази даних.
     * @param string $alias
     */
    public function show(string $alias): void
    {
        $data = $this->countryRepository->findByAlias($alias);

        if ($data) {
            http_response_code(200);
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Country not found']);
        }
    }
}

