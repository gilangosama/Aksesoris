<?php

namespace App\Filament\Resources\CustomizableJewelryResource\Pages;

use App\Filament\Resources\CustomizableJewelryResource;
use Filament\Resources\Pages\ListRecords;

class ListCustomizableJewelry extends ListRecords
{
    protected static string $resource = CustomizableJewelryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
