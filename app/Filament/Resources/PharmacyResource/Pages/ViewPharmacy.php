<?php

namespace App\Filament\Resources\PharmacyResource\Pages;

use App\Filament\Resources\PharmacyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPharmacy extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = PharmacyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
