<?php

namespace App\Filament\Resources\AboutResource\Pages;

use App\Filament\Resources\AboutResource;
use Filament\Actions\LocaleSwitcher;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditAbout extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = AboutResource::class;

    protected function getHeaderActions(): array
    {
        return [
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
            ->title('About edited')
            ->body('The About has been edited successfully.');
    }
}
