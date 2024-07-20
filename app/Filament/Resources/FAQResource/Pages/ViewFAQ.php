<?php

namespace App\Filament\Resources\FAQResource\Pages;

use App\Filament\Resources\FAQResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFAQ extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = FAQResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
    public function getTitle(): string
    {
        return 'Faqs';
    }
}
