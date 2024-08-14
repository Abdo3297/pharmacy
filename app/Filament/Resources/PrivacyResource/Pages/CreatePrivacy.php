<?php

namespace App\Filament\Resources\PrivacyResource\Pages;

use App\Filament\Resources\PrivacyResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreatePrivacy extends CreateRecord
{
    protected static string $resource = PrivacyResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('filament.privacy_navigation.create');
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
