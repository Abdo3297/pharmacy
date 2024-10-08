<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class CategoryProductNumber extends BaseWidget
{
    public ?Model $record = null;

    protected function getStats(): array
    {
        return [
            Stat::make(__('filament.category_navigation.widget.total_product_category'), $this->record->products()->count()),
        ];
    }
}
