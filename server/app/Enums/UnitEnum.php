<?php
namespace App\Enums;
use ArchTech\Enums\Values;

enum UnitEnum: string
{
    use Values;
    case GRAM = 'gr';
    case MILLILITER = 'ml';
    case PEACE = 'pc';
}
