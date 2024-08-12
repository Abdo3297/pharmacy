<?php

namespace App\Filament\Resources\PharmacyResource\Pages;

use App\Filament\Resources\PharmacyResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListPharmacies extends ListRecords
{
    protected static string $resource = PharmacyResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('filament.pharmacy_navigation.list');
    }
}
