<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomizableJewelryResource\Pages;
use App\Models\CustomizableJewelry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomizableJewelryResource extends Resource
{
    protected static ?string $model = CustomizableJewelry::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    
    protected static ?string $navigationLabel = 'Custom Jewelry';
    
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Jewelry Type Information')
                    ->schema([
                        Forms\Components\TextInput::make('type')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->helperText(__('admin.customizable_jewelry.helpers.jewelry_type_identifier')),
                        Forms\Components\TextInput::make('label')
                            ->required()
                            ->maxLength(255)
                            ->helperText(__('admin.customizable_jewelry.helpers.display_name')),
                        Forms\Components\TextInput::make('icon')
                            ->required()
                            ->maxLength(10)
                            ->helperText(__('admin.customizable_jewelry.helpers.emoji_icon')),
                    ])->columns(3),

                Forms\Components\Section::make('Product Image')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label(__('admin.customizable_jewelry.image_label'))
                            ->image()
                            ->disk('public')
                            ->directory('jewelry-types')
                            ->maxSize(5120)
                            ->helperText(__('admin.customizable_jewelry.image_helper')),
                    ]),

                Forms\Components\Section::make('Description & Pricing')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(3)
                            ->helperText('Description shown to customers'),
                        Forms\Components\TextInput::make('base_price')
                            ->label(__('admin.customizable_jewelry.labels.base_price') . ' (Rp)')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->step(1)
                            ->helperText('Starting price for this jewelry type in Indonesian Rupiah'),
                    ])->columns(1),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('admin.customizable_jewelry.labels.enable_customization'))
                            ->default(true)
                            ->helperText('Allow customers to customize this jewelry type'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('icon')
                    ->label('Icon')
                    ->width(80)
                    ->sortable(),
                Tables\Columns\TextColumn::make('label')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('base_price')
                    ->label('Base Price')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Types'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomizableJewelry::route('/'),
            'create' => Pages\CreateCustomizableJewelry::route('/create'),
            'edit' => Pages\EditCustomizableJewelry::route('/{record}/edit'),
        ];
    }
}
