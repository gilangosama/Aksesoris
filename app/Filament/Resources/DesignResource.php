<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DesignResource\Pages;
use App\Models\Design;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class DesignResource extends Resource
{
    protected static ?string $model = Design::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Custom Designs';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Design Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(Design::class, 'slug', ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(4),
                    ])->columns(2),

                Forms\Components\Section::make('Design Details')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->options([
                                'engagement_ring' => 'Engagement Ring',
                                'necklace' => 'Necklace',
                                'bracelet' => 'Bracelet',
                                'earring' => 'Earring',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\Select::make('style')
                            ->options([
                                'modern' => 'Modern',
                                'vintage' => 'Vintage',
                                'classic' => 'Classic',
                                'bohemian' => 'Bohemian',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\Select::make('material')
                            ->options([
                                '18k_gold' => '18K Gold',
                                'platinum' => 'Platinum',
                                'rose_gold' => 'Rose Gold',
                                'white_gold' => 'White Gold',
                                'silver' => 'Silver',
                            ])
                            ->required()
                            ->native(false),
                    ])->columns(3),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Main Image')
                            ->image()
                            ->directory('designs')
                            ->maxSize(5120),
                        Forms\Components\FileUpload::make('images')
                            ->label('Gallery Images')
                            ->image()
                            ->multiple()
                            ->directory('designs')
                            ->maxSize(5120),
                    ])->columns(2),

                Forms\Components\Section::make('Status & Badges')
                    ->schema([
                        Forms\Components\Toggle::make('featured')
                            ->label('Featured Design')
                            ->default(false),
                        Forms\Components\Toggle::make('client_pick')
                            ->label('Client Pick')
                            ->default(false),
                        Forms\Components\Toggle::make('trending')
                            ->label('Trending')
                            ->default(false),
                        Forms\Components\Toggle::make('limited')
                            ->label('Limited Edition')
                            ->default(false),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
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
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('style')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('material')
                    ->badge()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\IconColumn::make('featured')
                    ->boolean()
                    ->label('Featured'),
                Tables\Columns\IconColumn::make('trending')
                    ->boolean()
                    ->label('Trending'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'engagement_ring' => 'Engagement Ring',
                        'necklace' => 'Necklace',
                        'bracelet' => 'Bracelet',
                        'earring' => 'Earring',
                    ]),
                Tables\Filters\SelectFilter::make('style')
                    ->options([
                        'modern' => 'Modern',
                        'vintage' => 'Vintage',
                        'classic' => 'Classic',
                        'bohemian' => 'Bohemian',
                    ]),
                Tables\Filters\SelectFilter::make('material')
                    ->options([
                        '18k_gold' => '18K Gold',
                        'platinum' => 'Platinum',
                        'rose_gold' => 'Rose Gold',
                        'white_gold' => 'White Gold',
                        'silver' => 'Silver',
                    ]),
                Tables\Filters\TernaryFilter::make('featured')
                    ->label('Featured'),
                Tables\Filters\TernaryFilter::make('trending')
                    ->label('Trending'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
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
            'index' => Pages\ListDesigns::route('/'),
            'create' => Pages\CreateDesign::route('/create'),
            'edit' => Pages\EditDesign::route('/{record}/edit'),
        ];
    }
}
