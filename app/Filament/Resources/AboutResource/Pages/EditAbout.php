<?php

namespace App\Filament\Resources\AboutResource\Pages;

use App\Filament\Resources\AboutResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditAbout extends EditRecord
{
    protected static string $resource = AboutResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('filament.about_navigation.edit');
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
