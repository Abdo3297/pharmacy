<?php

namespace App\Filament\Resources\SideResource\Pages;

use App\Filament\Resources\SideResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSides extends ListRecords
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource = SideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
