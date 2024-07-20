<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Flowframe\Trend\Trend;
use Illuminate\Support\Carbon;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class RevenuChart extends ApexChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $chartId = 'revenusChart';
    protected static ?string $heading = 'Total Revenu Per Month';
    protected static ?int $sort = 5;
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
            ->sum('total_amount');
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
                    'name' => 'Total Amount',
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
                    'text' => 'Total Revenu',
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ]
        ];
    }
}
