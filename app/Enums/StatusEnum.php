<?php

namespace App\Enums;

enum StatusEnum: string
{
    case DEBT = 'debt';
    case CASH = 'cash';
    case SPLIT = 'split';
}
