<?php

namespace App\Filament\Resources\TermResource\Pages;

use App\Filament\Resources\TermResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTerm extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;
    protected static string $resource = TermResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
