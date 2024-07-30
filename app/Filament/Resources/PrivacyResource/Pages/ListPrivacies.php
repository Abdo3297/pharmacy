<?php

namespace App\Filament\Resources\PrivacyResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PrivacyResource;

class ListPrivacies extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = PrivacyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
