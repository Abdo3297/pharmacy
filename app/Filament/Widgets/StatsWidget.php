<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

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
            Stat::make(__('filament.main_page.card.user'), User::where('email_verified_at', '!=', null)
                ->where('is_admin', false)
                ->when($start, fn ($query) => $query->whereDate('created_at', '>=', $start))
                ->when($end, fn ($query) => $query->whereDate('created_at', '<=', $end))
                ->count()),
            Stat::make(__('filament.main_page.card.order'), Order::where('payment_status', true)
                ->when($start, fn ($query) => $query->whereDate('created_at', '>=', $start))
                ->when($end, fn ($query) => $query->whereDate('created_at', '<=', $end))
                ->count()),
            Stat::make(__('filament.main_page.card.revenu'), '£'.' '.Order::where('payment_status', true)
                ->when($start, fn ($query) => $query->whereDate('created_at', '>=', $start))
                ->when($end, fn ($query) => $query->whereDate('created_at', '<=', $end))
                ->sum('total_amount')),
        ];
    }
}
