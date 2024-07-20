<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\CategoryResource\Widgets\CategoryProductNumber;

class ViewCategory extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;
    protected static string $resource = CategoryResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            CategoryProductNumber::class,
        ];
    }
}
