<?php

namespace App\Filament\Resources\PharmacyResource\Pages;

use App\Filament\Resources\PharmacyResource;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditPharmacy extends EditRecord
{
    protected static string $resource = PharmacyResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('filament.pharmacy_navigation.edit');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
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
