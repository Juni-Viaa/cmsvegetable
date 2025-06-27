<?php

namespace App\Enums;

enum TargetType: string
{
    case Product = 'App\Models\Product';
    case Blog = 'App\Models\Blog';
}
