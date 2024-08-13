<?php

namespace App\Filament\Resources\SideResource\Pages;

use App\Filament\Resources\SideResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateSide extends CreateRecord
{
    protected static string $resource = SideResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Side created')
            ->body('The Side has been created successfully.');
    }
    public function getTitle(): string|Htmlable
    {
        return __('filament.side_navigation.create');
    }
}
