<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static ?string $navigationLabel = 'Orders';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Information')
                    ->schema([
                        Forms\Components\TextInput::make('order_id')
                            ->label('Order ID')
                            ->disabled()
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending (Waiting Payment)',
                                'completed' => 'Completed (Paid)',
                                'process' => 'Processing',
                                'delivery' => 'Delivery',
                                'success' => 'Success',
                                'failed' => 'Failed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('transaction_id')
                            ->label('Transaction ID')
                            ->disabled(),
                        Forms\Components\TextInput::make('tracking_number')
                            ->label('Tracking Number (Nomor Resi)')
                            ->disabled(),
                        Forms\Components\TextInput::make('payment_method')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Customer Information')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Customer Name')
                            ->disabled(),
                        Forms\Components\TextInput::make('customer_email')
                            ->label('Customer Email')
                            ->email()
                            ->disabled(),
                        Forms\Components\TextInput::make('customer_phone')
                            ->label('Customer Phone')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Delivery Address')
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->label('Complete Delivery Address')
                            ->rows(5)
                            ->disabled()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Custom Design Info')
                    ->schema([
                        Forms\Components\TextInput::make('designInquiry.reference_design')
                            ->label('Reference Design URL')
                            ->disabled(),
                        Forms\Components\TextInput::make('designInquiry.chainStyle.name')
                            ->label('Chain Style')
                            ->disabled(),
                        Forms\Components\TextInput::make('designInquiry.chainStyle.image')
                            ->label('Chain Style Image URL')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Order Details')
                    ->schema([
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(),
                    ]),

                Forms\Components\Section::make('Order Items')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('product_name')
                                    ->disabled(),
                                Forms\Components\TextInput::make('quantity')
                                    ->numeric()
                                    ->disabled(),
                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->disabled(),
                            ])
                            ->columns(3)
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->label('Order ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'success',
                        'info' => 'completed',
                        'primary' => 'process',
                        'secondary' => 'delivery',
                        'warning' => 'pending',
                        'danger' => 'failed',
                        'secondary' => 'cancelled',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending (Waiting Payment)',
                        'completed' => 'Completed (Paid)',
                        'process' => 'Processing',
                        'delivery' => 'Delivery',
                        'success' => 'Success',
                        'failed' => 'Failed',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('accept')
                    ->label('Terima Orderan')
                    ->icon('heroicon-m-check')
                    ->color('success')
                    ->visible(fn (Order $record): bool => $record->status === 'completed')
                    ->requiresConfirmation()
                    ->modalHeading('Terima Orderan')
                    ->modalDescription('Apakah Anda yakin ingin menerima orderan ini? Status akan berubah menjadi "Proses".')
                    ->modalSubmitActionLabel('Ya, Terima')
                    ->action(function (Order $record) {
                        $record->update(['status' => 'process']);
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Orderan Diterima')
                            ->body('Status orderan berhasil diubah menjadi Proses.')
                    ),

                Tables\Actions\Action::make('deliver')
                    ->label('Kirim Orderan')
                    ->icon('heroicon-m-truck')
                    ->color('info')
                    ->visible(fn (Order $record): bool => $record->status === 'process')
                    ->form([
                        Forms\Components\TextInput::make('tracking_number')
                            ->label('Nomor Resi (Tracking Number)')
                            ->required()
                            ->placeholder('Masukkan nomor resi pengiriman')
                            ->helperText('Contoh: JNE123456789, TIKI123456789')
                            ->columnSpanFull(),
                    ])
                    ->modalHeading('Kirim Orderan')
                    ->modalDescription('Masukkan nomor resi pengiriman untuk orderan ini.')
                    ->modalSubmitActionLabel('Ya, Kirim')
                    ->modalCancelActionLabel('Batal')
                    ->action(function (Order $record, array $data) {
                        $record->update([
                            'status' => 'delivery',
                            'tracking_number' => $data['tracking_number'],
                        ]);
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Orderan Dikirim')
                            ->body('Status orderan berhasil diubah menjadi Delivery dan nomor resi telah tersimpan.')
                    ),

                Tables\Actions\Action::make('complete')
                    ->label('Selesaikan Orderan')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->visible(fn (Order $record): bool => $record->status === 'delivery')
                    ->requiresConfirmation()
                    ->modalHeading('Selesaikan Orderan')
                    ->modalDescription('Orderan sudah sampai ke customer. Status akan berubah menjadi "Success".')
                    ->modalSubmitActionLabel('Ya, Selesaikan')
                    ->action(function (Order $record) {
                        $record->update(['status' => 'success']);
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Orderan Selesai')
                            ->body('Status orderan berhasil diubah menjadi Success.')
                    ),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['addressRecord', 'designInquiry.chainStyle', 'designInquiry.charms']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
