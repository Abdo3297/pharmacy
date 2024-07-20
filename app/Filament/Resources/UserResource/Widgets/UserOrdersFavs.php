<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Illuminate\Database\Eloquent\Model;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserOrdersFavs extends BaseWidget
{
    protected function getColumns(): int
    {
        return 2;
    }
    public ?Model $record = null;
    protected function getStats(): array
    {
        return [
            Stat::make('orders', $this->record->orders()->count()),
            Stat::make('favourites', $this->record->favourites()->count()),
        ];
    }
}
