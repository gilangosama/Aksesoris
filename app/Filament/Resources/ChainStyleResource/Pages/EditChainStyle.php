<?php

namespace App\Filament\Resources\ChainStyleResource\Pages;

use App\Filament\Resources\ChainStyleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChainStyle extends EditRecord
{
    protected static string $resource = ChainStyleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}