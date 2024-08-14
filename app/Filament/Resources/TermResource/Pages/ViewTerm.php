<?php

namespace App\Filament\Resources\TermResource\Pages;

use App\Filament\Resources\TermResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewTerm extends ViewRecord
{
    protected static string $resource = TermResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('filament.term_navigation.view');
    }

    protected function getHeaderActions(): array
    {
        return [

            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
