<?php

namespace App\Filament\Resources\PrivacyResource\Pages;

use Filament\Actions\LocaleSwitcher;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PrivacyResource;

class CreatePrivacy extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    protected static string $resource = PrivacyResource::class;
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
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Privacy created')
            ->body('The Privacy has been created successfully.');
    }
}
