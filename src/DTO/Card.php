<?php

namespace App\DTO;

/*
cardNumber , int 
name , string 
expiredDate , date 
cvcNumber , int 
adress , string 
 */
class Card
{
    public ?int $cardNumber = null;

    public ?string $name = null;

    public $expiredDate = null;

    public ?int $cvcNumber = null;

    public ?string $adress = null;

}