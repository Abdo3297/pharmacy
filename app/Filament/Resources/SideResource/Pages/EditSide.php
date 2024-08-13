<?php

namespace App\Filament\Resources\SideResource\Pages;

use App\Filament\Resources\SideResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditSide extends EditRecord
{
    protected static string $resource = SideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
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

    public function getTitle(): string|Htmlable
    {
        return __('filament.side_navigation.edit');
    }
}
