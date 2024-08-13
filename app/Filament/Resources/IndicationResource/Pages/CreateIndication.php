<?php

namespace App\Filament\Resources\IndicationResource\Pages;

use App\Filament\Resources\IndicationResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateIndication extends CreateRecord
{
    protected static string $resource = IndicationResource::class;

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
    public function getTitle(): string|Htmlable
    {
        return __('filament.indication_navigation.create');
    }
}
