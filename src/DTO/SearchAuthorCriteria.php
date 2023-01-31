<?php

namespace App\DTO;
/*
| Nom       | type    | valeur par défaut |
| --------- | ------- | ----------------- |
| name      | ?string | null              |
| orderBy   | ?string | 'id'              |
| direction | ?string | 'DESC'            |
| limit     | ?int    | 25                |
| page      | ?int    | 1                 |
*/

class SearchAuthorCriteria
{
    public ?string $name = null;

    public ?string $orderBy = 'id';

    public ?string $direction = 'DESC';

    public ?int $limit = 25;

    public ?int $page = 1;
}
