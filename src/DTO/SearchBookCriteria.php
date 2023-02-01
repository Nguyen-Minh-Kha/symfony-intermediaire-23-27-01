<?php

namespace App\DTO;
/*
| nom        | type   | valeur par défaut |
| ---------- | ------ | ----------------- |
| title      | string | `''`              |
| authors    | array  | `[]`              |
| categories | array  | `[]`              |
| minPrice   | ?float | null              |
| maxPrice   | ?float | null              |

| nom              | type    | valeur par défaut |
| ---------------- | ------- | ----------------- |
| publishingHouses | ?array  | []                |
| orderBy          | ?string | 'title'           |
| direction        | ?string | 'ASC'             |
| limit            | ?int    | 25                |
| page             | ?int    | 1                 |
*/

class SearchBookCriteria
{
    public ?string $title = '';

    public ?array $authors = [];

    public ?array $categories = [];

    public ?float $minPrice = null;

    public ?float $maxPrice = null;

    public ?array $publishingHouses = [];

    public ?string $orderBy = 'title';

    public ?string $direction = 'ASC';

    public ?int $limit = 25;

    public ?int $page = 1;
}
