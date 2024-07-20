<?php

namespace App\Filament\Resources\IndicationResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\IndicationResource;

class CreateIndication extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    protected static string $resource = IndicationResource::class;
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
            ->title('Indication created')
            ->body('The Indication has been created successfully.');
    }
}
