<?php

namespace App\Filament\Resources\IndicationResource\Pages;

use App\Filament\Resources\IndicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIndications extends ListRecords
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource = IndicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
