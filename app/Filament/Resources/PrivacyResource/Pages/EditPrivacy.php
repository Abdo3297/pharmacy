<?php

namespace App\Filament\Resources\PrivacyResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PrivacyResource;

class EditPrivacy extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    protected static string $resource = PrivacyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
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
            ->title('Privacy edited')
            ->body('The Privacy has been edited successfully.');
    }
}
