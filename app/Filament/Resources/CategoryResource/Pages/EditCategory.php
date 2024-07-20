<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CategoryResource;
use App\Filament\Widgets\ProductNumberInCategory;
use App\Filament\Resources\CategoryResource\Widgets\CategoryProductNumber;

class EditCategory extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
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
            ->title('Category edited')
            ->body('The Category has been edited successfully.');
    }
    protected function getHeaderWidgets(): array
    {
        return [
            CategoryProductNumber::class,
        ];
    }
}
