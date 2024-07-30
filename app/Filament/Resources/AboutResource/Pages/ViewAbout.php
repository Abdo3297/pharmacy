<?php

namespace App\Filament\Resources\AboutResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\AboutResource;

class ViewAbout extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;
    protected static string $resource = AboutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
