<?php

namespace App\Filament\Resources\FAQResource\Pages;

use Filament\Actions;
use App\Filament\Resources\FAQResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditFAQ extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = FAQResource::class;

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
            ->title('FAQ edited')
            ->body('The FAQ has been edited successfully.');
    }
    public function getTitle(): string
    {
        return 'Faqs';
    }
}
