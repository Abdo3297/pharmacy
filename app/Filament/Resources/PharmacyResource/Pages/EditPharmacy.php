<?php

namespace App\Filament\Resources\PharmacyResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PharmacyResource;

class EditPharmacy extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    protected static string $resource = PharmacyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            LocaleSwitcher::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Pharmacy Details edited')
            ->body('The Pharmacy has been edited successfully.');
    }
}
