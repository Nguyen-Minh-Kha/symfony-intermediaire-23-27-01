<?php
namespace App\DTO;

class SearchBookCriteria
{
    public ?string $title = '';

    public ?array $authors = [];

    public ?array $categories = [];

    public ?float $minPrice = null;

    public ?float $maxPrice = null;
}
