<?php

namespace App\Filament\Resources\IndicationResource\Pages;

use App\Filament\Resources\IndicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewIndication extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;
    protected static string $resource = IndicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
