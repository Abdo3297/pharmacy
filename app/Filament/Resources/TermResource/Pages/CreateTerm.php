<?php

namespace App\Filament\Resources\TermResource\Pages;

use App\Filament\Resources\TermResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateTerm extends CreateRecord
{
    protected static string $resource = TermResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('filament.term_navigation.create');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Term created')
            ->body('The Term has been created successfully.');
    }
}
