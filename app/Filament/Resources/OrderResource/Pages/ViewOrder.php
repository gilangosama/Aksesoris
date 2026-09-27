<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Order Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('order_id')
                            ->label('Order ID'),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'completed' => 'info',
                                'process' => 'warning',
                                'delivery' => 'primary',
                                'success' => 'success',
                                'pending' => 'warning',
                                'failed' => 'danger',
                                default => 'secondary',
                            }),
                        Infolists\Components\TextEntry::make('transaction_id')
                            ->label('Transaction ID'),
                        Infolists\Components\TextEntry::make('tracking_number')
                            ->label('Tracking Number'),
                        Infolists\Components\TextEntry::make('payment_method')
                            ->label('Payment Method'),
                    ])->columns(2),

                Infolists\Components\Section::make('Customer Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('customer_name')
                            ->label('Customer Name'),
                        Infolists\Components\TextEntry::make('customer_email')
                            ->label('Email'),
                        Infolists\Components\TextEntry::make('customer_phone')
                            ->label('Phone'),
                    ])->columns(2),

                Infolists\Components\Section::make('Delivery Address')
                    ->schema([
                        Infolists\Components\TextEntry::make('addressRecord.recipient_name')
                            ->label('Recipient Name'),
                        Infolists\Components\TextEntry::make('addressRecord.phone')
                            ->label('Phone Number'),
                        Infolists\Components\TextEntry::make('addressRecord.street')
                            ->label('Street')
                            ->columnSpan(2),
                        Infolists\Components\TextEntry::make('addressRecord.city')
                            ->label('City'),
                        Infolists\Components\TextEntry::make('addressRecord.province')
                            ->label('Province'),
                        Infolists\Components\TextEntry::make('addressRecord.postal_code')
                            ->label('Postal Code'),
                    ])->columns(2),

                Infolists\Components\Section::make('Custom Design')
                    ->schema([
                        Infolists\Components\TextEntry::make('designInquiry.reference_design')
                            ->label('Reference Design URL'),
                        Infolists\Components\TextEntry::make('designInquiry.chainStyle.name')
                            ->label('Chain Style'),
                        Infolists\Components\TextEntry::make('designInquiry.chainStyle.image')
                            ->label('Chain Style Image URL'),
                        Infolists\Components\TextEntry::make('designInquiry.charms')
                            ->label('Charms')
                            ->formatStateUsing(fn ($state, $record) => $record?->designInquiry?->charms?->pluck('name')->join(', ') ?? '-'),
                        Infolists\Components\TextEntry::make('designInquiry.charms')
                            ->label('Charms Image URLs')
                            ->formatStateUsing(fn ($state, $record) => $record?->designInquiry?->charms?->pluck('image')->filter()->join(', ') ?? '-'),
                    ])->columns(1),

                Infolists\Components\Section::make('Custom Design (Preview + Download)')
                    ->schema([
                        ViewEntry::make('designInquiry')
                            ->view('filament.infolists.entries.custom-design-images'),
                    ]),

                Infolists\Components\Section::make('Order Summary')
                    ->schema([
                        Infolists\Components\TextEntry::make('total_price')
                            ->label('Total Amount')
                            ->money('IDR'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Order Date')
                            ->dateTime(),
                    ])->columns(2),
            ]);
    }
}
