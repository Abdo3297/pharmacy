<?php

namespace App\Filament\Resources\TermResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\LocaleSwitcher;
use App\Filament\Resources\TermResource;
use Filament\Resources\Pages\ViewRecord;

class ViewTerm extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;
    protected static string $resource = TermResource::class;
    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
