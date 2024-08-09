<?php

namespace App\Enums;

enum UploadDiskEnum: string
{
    case PRODUCT = 'products';
    case USER = 'users';
    case COST = 'costs';
}
