<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Flowframe\Trend\Trend;
use Illuminate\Support\Carbon;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class UsersChart extends ApexChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $chartId = 'usersChart';
    protected static ?string $heading = 'Total Customres Per Month';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    protected function getOptions(): array
    {
        $start = $this->filters['startDate'] ?? null;
        $end = $this->filters['endDate'] ?? null;
        $data = Trend::model(User::class)
            ->between(
                start: $start ? Carbon::parse($start) : now()->startOfYear(),
                end: $end ? Carbon::parse($end) : now()->endOfYear(),
            )
            ->perMonth()
            ->count();
        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'colors' => ['#37afb5'],
            'stroke' => [
                'curve' => 'smooth',
            ],
            'series' => [
                [
                    'name' => 'Users Joined',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'xaxis' => [
                'categories' => $data->map(fn(TrendValue $value) => $value->date),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
                'title' => [
                    'text' => 'This Month',
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
                'title' => [
                    'text' => 'Number Of Customers Joined',
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
        ];
    }
}
