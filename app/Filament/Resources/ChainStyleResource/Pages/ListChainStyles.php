<?php

namespace App\Filament\Resources\ChainStyleResource\Pages;

use App\Filament\Resources\ChainStyleResource;
use Filament\Resources\Pages\ListRecords;

class ListChainStyles extends ListRecords
{
    protected static string $resource = ChainStyleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}