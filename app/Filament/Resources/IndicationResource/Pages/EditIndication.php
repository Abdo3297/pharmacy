<?php

namespace App\Filament\Resources\IndicationResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\IndicationResource;

class EditIndication extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    protected static string $resource = IndicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
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
            ->title('Indication edited')
            ->body('The Indication has been edited successfully.');
    }
}
