<?php

namespace App\Filament\Resources\TermResource\Pages;

use Filament\Actions;
use App\Filament\Resources\TermResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateTerm extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    protected static string $resource = TermResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
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
            ->title('Term created')
            ->body('The Term has been created successfully.');
    }
}
