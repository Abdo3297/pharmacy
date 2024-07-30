<?php

namespace App\Filament\Resources\PrivacyResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\PrivacyResource;

class ViewPrivacy extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;
    protected static string $resource = PrivacyResource::class;
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
