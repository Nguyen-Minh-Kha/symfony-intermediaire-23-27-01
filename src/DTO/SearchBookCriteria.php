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
*/

class SearchBookCriteria
{
    public ?string $title = '';

    public ?array $authors = [];

    public ?array $categories = [];

    public ?float $minPrice = null;

    public ?float $maxPrice = null;
}
