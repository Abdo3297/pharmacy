<?php

namespace App\Enums;

enum PaymenType: string
{
    case CASH = 'cash';
    case SRTIPE = 'stripe';
}
