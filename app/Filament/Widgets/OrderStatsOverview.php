<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'completed')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('amount');

        return [
            Stat::make('Total Orders', $totalOrders)
                ->description('All orders')
                ->icon('heroicon-o-shopping-cart')
                ->color('primary'),
            Stat::make('Completed Orders', $completedOrders)
                ->description('Finished transactions')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('Pending Orders', $pendingOrders)
                ->description('Waiting for payment')
                ->icon('heroicon-o-clock')
                ->color('warning'),
            Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('From completed orders')
                ->icon('heroicon-o-banknotes')
                ->color('info'),
        ];
    }
}
