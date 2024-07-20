<?php

namespace App\Filament\Resources\SideResource\Pages;

use Filament\Actions;
use App\Filament\Resources\SideResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditSide extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    protected static string $resource = SideResource::class;

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
            ->title('Side edited')
            ->body('The Side has been edited successfully.');
    }
}
