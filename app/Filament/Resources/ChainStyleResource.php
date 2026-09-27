<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChainStyleResource\Pages;
use App\Models\ChainStyle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ChainStyleResource extends Resource
{
    protected static ?string $model = ChainStyle::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';
    
    protected static ?string $navigationLabel = 'Chain Styles';
    
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Chain Style Information')
                    ->schema([
                        Forms\Components\Select::make('customizable_jewelry_id')
                            ->label('Jewelry Type')
                            ->required()
                            ->relationship('jewelry', 'label')
                            ->helperText('Select which jewelry type this chain style is for'),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->helperText('e.g., "Gold Link Chain"'),
                        Forms\Components\Select::make('finish')
                            ->required()
                            ->options([
                                'silver' => 'Silver',
                                'gold' => 'Gold',
                            ])
                            ->helperText('Chain metal finish'),
                        Forms\Components\Repeater::make('sizes')
                            ->label('Chain Sizes')
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Size label')
                                    ->helperText('e.g., "40 cm", "45 cm"'),
                                Forms\Components\TextInput::make('length')
                                    ->label('Length (cm)')
                                    ->numeric()
                                    ->helperText('Optional numeric length in centimeters'),
                                Forms\Components\TextInput::make('price_add')
                                    ->label('Additional Price (Rp)')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Optional extra price for this chain size'),
                                Forms\Components\Toggle::make('recommended')
                                    ->label('Recommended')
                                    ->helperText('Mark this chain size as recommended for customers'),
                                Forms\Components\TextInput::make('total_space')
                                    ->label('Total Space Units')
                                    ->numeric()
                                    ->min(2)
                                    ->default(8)
                                    ->helperText('Available space units for charms on this chain size'),
                            ])
                            ->createItemButtonLabel('Add Size')
                            ->columns(3)
                            ->helperText('Add available chain size options for this style'),
                    ])->columns(2),

                Forms\Components\Section::make('Media & Status')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Chain Preview Image')
                            ->image()
                            ->directory('chain-styles')
                            ->maxSize(5120)
                            ->helperText('Upload a preview image of this chain style'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Make this chain style available for customers'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jewelry.label')
                    ->label('Jewelry Type')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sizes')
                    ->label('Size Options')
                    ->formatStateUsing(fn($state) => is_array($state) ? count($state) . ' option' : '0 option'),
                Tables\Columns\BadgeColumn::make('finish')
                    ->colors([
                        'secondary' => 'silver',
                        'warning' => 'gold',
                    ])
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('jewelry')
                    ->relationship('jewelry', 'label')
                    ->label('Jewelry Type'),
                Tables\Filters\SelectFilter::make('finish')
                    ->options([
                        'silver' => 'Silver',
                        'gold' => 'Gold',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Styles'),
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
            'index' => Pages\ListChainStyles::route('/'),
            'create' => Pages\CreateChainStyle::route('/create'),
            'edit' => Pages\EditChainStyle::route('/{record}/edit'),
        ];
    }
}
