<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\OrderStatsOverview;
use App\Filament\Widgets\OrderSalesChart;
use App\Filament\Widgets\OrderStatusChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            OrderStatsOverview::class,
            OrderSalesChart::class,
            OrderStatusChart::class,
        ];
    }
}
