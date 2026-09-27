<?php

namespace App\Filament\Resources\CharmResource\Pages;

use App\Filament\Resources\CharmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCharms extends ListRecords
{
    protected static string $resource = CharmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
