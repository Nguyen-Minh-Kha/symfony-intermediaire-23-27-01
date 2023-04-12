<?php

namespace App\DTO;

use App\Entity\Address;


class Card
{
    public ?string $cardNumber;
    public ?string $cardName;
    public ?string $expirationDate;
    public ?string $cvc;
    public ?Address $address;
}