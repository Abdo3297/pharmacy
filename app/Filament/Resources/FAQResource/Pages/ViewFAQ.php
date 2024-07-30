<?php

namespace App\Filament\Resources\FaqResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\LocaleSwitcher;
use App\Filament\Resources\FaqResource;
use Filament\Resources\Pages\ViewRecord;

class ViewFaq extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = FaqResource::class;
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
