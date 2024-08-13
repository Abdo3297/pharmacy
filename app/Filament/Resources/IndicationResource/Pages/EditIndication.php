<?php

namespace App\Filament\Resources\IndicationResource\Pages;

use App\Filament\Resources\IndicationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditIndication extends EditRecord
{
    protected static string $resource = IndicationResource::class;

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
            ->title('Indication edited')
            ->body('The Indication has been edited successfully.');
    }

    public function getTitle(): string|Htmlable
    {
        return __('filament.indication_navigation.edit');
    }
}
