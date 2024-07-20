<?php

namespace App\Filament\Resources\FAQResource\Pages;

use App\Filament\Resources\FAQResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFAQS extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = FAQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
    public function getTitle(): string
    {
        return 'Faqs';
    }
}
