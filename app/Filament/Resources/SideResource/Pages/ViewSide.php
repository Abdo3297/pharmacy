<?php

namespace App\Filament\Resources\SideResource\Pages;

use App\Filament\Resources\SideResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewSide extends ViewRecord
{
    protected static string $resource = SideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
    public function getTitle(): string|Htmlable
    {
        return __('filament.side_navigation.view');
    }
}
