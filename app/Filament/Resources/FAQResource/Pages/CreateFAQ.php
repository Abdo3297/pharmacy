<?php

namespace App\Filament\Resources\FAQResource\Pages;

use Filament\Actions;
use App\Filament\Resources\FAQResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateFAQ extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    protected static string $resource = FAQResource::class;
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
            ->title('FAQ created')
            ->body('The FAQ has been created successfully.');
    }
    public function getTitle(): string
    {
        return 'Faqs';
    }
}
