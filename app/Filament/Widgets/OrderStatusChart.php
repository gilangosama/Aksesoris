<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrderStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Order Status Distribution';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $statuses = Order::selectRaw('status')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Orders by Status',
                    'data' => $statuses->pluck('count')->toArray(),
                    'backgroundColor' => [
                        '#22c55e', // completed - green
                        '#eab308', // pending - yellow
                        '#ef4444', // failed - red
                        '#6b7280', // cancelled - gray
                    ],
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $statuses->pluck('status')->map(fn($status) => ucfirst($status))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
