<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CharmResource\Pages;
use App\Models\Charm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CharmResource extends Resource
{
    protected static ?string $model = Charm::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    
    protected static ?string $navigationLabel = 'Charms & Pendants';
    
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Charm Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->helperText('e.g., "Diamond Heart", "Pearl Drop"'),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(4)
                            ->maxLength(65535)
                            ->helperText('Short description of the charm, such as style or size details'),
                        Forms\Components\TextInput::make('size')
                            ->label('Size')
                            ->maxLength(255)
                            ->helperText('Size or dimension for the charm'),
                        Forms\Components\TextInput::make('space_required')
                            ->label('Space Required')
                            ->numeric()
                            ->min(1)
                            ->max(5)
                            ->default(1)
                            ->helperText('Space units needed (1=tiny, 5=very large). Affects maximum charms on chain'),
                        Forms\Components\Select::make('category')
                            ->options([
                                'diamonds' => 'Diamonds',
                                'pearls' => 'Pearls',
                                'crystals' => 'Crystals',
                                'gemstones' => 'Gemstones',
                                'metal' => 'Metal Tags',
                                'other' => 'Other',
                            ])
                            ->helperText('Category for quick search filters'),
                        Forms\Components\TextInput::make('price_add')
                            ->label('Additional Price (Rp)')
                            ->numeric()
                            ->default(0)
                            ->helperText('Extra price for this charm option in Indonesian Rupiah'),
                        Forms\Components\TextInput::make('stock')
                            ->label('Stock Quantity')
                            ->numeric()
                            ->default(999)
                            ->required()
                            ->helperText('Available stock for this charm'),
                    ])->columns(2),

                Forms\Components\Section::make('Media & Status')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Charm Preview Image')
                            ->image()
                            ->directory('charms')
                            ->maxSize(5120)
                            ->helperText('Upload a preview image of this charm'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Make this charm available for customers'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('size')
                    ->label('Size')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_add')
                    ->label('Extra Price')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state > 0 ? '✓ ' . $state : '⚠ Out'),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Preview'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'diamonds' => 'Diamonds',
                        'pearls' => 'Pearls',
                        'crystals' => 'Crystals',
                        'gemstones' => 'Gemstones',
                        'metal' => 'Metal Tags',
                        'other' => 'Other',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Charms'),
            ])
            ->actions([
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCharms::route('/'),
            'create' => Pages\CreateCharm::route('/create'),
            'edit' => Pages\EditCharm::route('/{record}/edit'),
        ];
    }
}
