<?php

namespace App\Filament\Resources\SideResource\Pages;

use App\Filament\Resources\SideResource;
use Filament\Actions\LocaleSwitcher;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateSide extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = SideResource::class;

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
            ->title('Side created')
            ->body('The Side has been created successfully.');
    }
}
