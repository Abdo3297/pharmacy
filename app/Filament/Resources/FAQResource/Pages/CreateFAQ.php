<?php

namespace App\Filament\Resources\FaqResource\Pages;

use Filament\Actions\LocaleSwitcher;
use App\Filament\Resources\FaqResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateFaq extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    protected static string $resource = FaqResource::class;
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
            ->title('FAQ created')
            ->body('The FAQ has been created successfully.');
    }
}
