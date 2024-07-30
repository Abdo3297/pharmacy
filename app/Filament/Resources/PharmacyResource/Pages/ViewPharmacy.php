<?php

namespace App\Filament\Resources\PharmacyResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\PharmacyResource;

class ViewPharmacy extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = PharmacyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
