<?php

namespace App\Filament\Resources\PharmacyResource\Pages;

use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PharmacyResource;

class ListPharmacies extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = PharmacyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
