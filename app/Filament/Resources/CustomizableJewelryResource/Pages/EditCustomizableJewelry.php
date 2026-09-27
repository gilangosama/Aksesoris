<?php

namespace App\Filament\Resources\CustomizableJewelryResource\Pages;

use App\Filament\Resources\CustomizableJewelryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomizableJewelry extends EditRecord
{
    protected static string $resource = CustomizableJewelryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
