<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StoreWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getColumns(): int
    {
        return 2;
    }
    protected function getStats(): array
    {
        return [
            Stat::make('Categories', Category::count()),
            Stat::make('Products', Product::count()),
        ];
    }
}
