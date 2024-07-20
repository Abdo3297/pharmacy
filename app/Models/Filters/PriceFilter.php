<?php

namespace App\Models\Filters;

use Lacodix\LaravelModelFilter\Enums\FilterMode;
use Lacodix\LaravelModelFilter\Filters\NumericFilter;

class PriceFilter extends NumericFilter
{
    public FilterMode $mode = FilterMode::BETWEEN;
    protected string $field = 'unit_price';
}
