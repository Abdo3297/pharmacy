<?php

namespace App\Filament\Resources\SideResource\Pages;

use App\Filament\Resources\SideResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListSides extends ListRecords
{
    protected static string $resource = SideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return __('filament.side_navigation.list');
    }
}
