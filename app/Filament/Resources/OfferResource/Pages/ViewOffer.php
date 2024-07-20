<?php

namespace App\Filament\Resources\OfferResource\Pages;

use App\Filament\Resources\OfferResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOffer extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;
    protected static string $resource = OfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
