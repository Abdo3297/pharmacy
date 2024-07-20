<?php

namespace App\Filament\Resources\AboutResource\Pages;

use App\Filament\Resources\AboutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbouts extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = AboutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
