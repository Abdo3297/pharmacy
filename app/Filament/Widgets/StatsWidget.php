<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsWidget extends BaseWidget
{
    use InteractsWithPageFilters;
    protected static ?int $sort = 2;
    protected function getColumns(): int
    {
        return 3;
    }
    protected function getStats(): array
    {
        $start = $this->filters['startDate'] ?? null;
        $end = $this->filters['endDate'] ?? null;
        return [
            Stat::make('Customers', User::where('email_verified_at', '!=', Null)
                ->where('is_admin', false)
                ->when($start, fn ($query) => $query->whereDate('created_at', '>=', $start))
                ->when($end, fn ($query) => $query->whereDate('created_at', '<=', $end))
                ->count()),
            Stat::make('Orders', Order::where('payment_status', true)
                ->when($start, fn ($query) => $query->whereDate('created_at', '>=', $start))
                ->when($end, fn ($query) => $query->whereDate('created_at', '<=', $end))
                ->count()),
            Stat::make('Renevu', '$ ' .Order::where('payment_status', true)
                ->when($start, fn ($query) => $query->whereDate('created_at', '>=', $start))
                ->when($end, fn ($query) => $query->whereDate('created_at', '<=', $end))
                ->sum('total_amount')),
        ];
    }
}
