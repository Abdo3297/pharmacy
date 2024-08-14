<?php

namespace App\Filament\Resources\FaqResource\Pages;

use App\Filament\Resources\FaqResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateFaq extends CreateRecord
{
    protected static string $resource = FaqResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('filament.faq_navigation.create');
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
