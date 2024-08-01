<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\CategoryResource\Widgets\CategoryProductNumber;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ViewRecord;

class ViewCategory extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
            LocaleSwitcher::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CategoryProductNumber::class,
        ];
    }
}
