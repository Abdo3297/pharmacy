<?php

namespace App\Filament\Resources\IndicationResource\Pages;

use App\Filament\Resources\IndicationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewIndication extends ViewRecord
{
    protected static string $resource = IndicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return __('filament.indication_navigation.view');
    }
}
