<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

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
            Stat::make(__('filament.user_navigation .widget.orders'), $this->record->orders()->count()),
            Stat::make(__('filament.user_navigation .widget.favourites'), $this->record->favourites()->count()),
        ];
    }
}
