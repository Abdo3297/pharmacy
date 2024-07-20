<?php

namespace App\Filament\Resources\OfferResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use App\Filament\Resources\OfferResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOffer extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    protected static string $resource = OfferResource::class;
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
            ->title('Offer created')
            ->body('The Offer has been created successfully.');
    }
}
