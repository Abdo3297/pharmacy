<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class OrdersChart extends ApexChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $chartId = 'ordersChart';

    protected static ?string $heading = 'Total Orders Per Month';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = '1';

    protected function getOptions(): array
    {
        $start = $this->filters['startDate'] ?? null;
        $end = $this->filters['endDate'] ?? null;
        $data = Trend::query(Order::where('payment_status', true))
            ->between(
                start: $start ? Carbon::parse($start) : now()->startOfYear(),
                end: $end ? Carbon::parse($end) : now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'colors' => ['#37afb5'],
            'stroke' => [
                'curve' => 'smooth',
            ],
            'series' => [
                [
                    'name' => 'Total Orders',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'xaxis' => [
                'categories' => $data->map(fn (TrendValue $value) => $value->date),
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
                    'text' => 'Number Of Orders',
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
        ];
    }
}
