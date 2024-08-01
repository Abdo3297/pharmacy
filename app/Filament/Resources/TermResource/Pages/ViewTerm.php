<?php

namespace App\Filament\Resources\TermResource\Pages;

use App\Filament\Resources\TermResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTerm extends ViewRecord
{
    protected static string $resource = TermResource::class;

    protected function getHeaderActions(): array
    {
        return [

            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
