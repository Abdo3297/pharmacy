<?php

namespace App\Filament\Resources\AboutResource\Pages;

use App\Filament\Resources\AboutResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListAbouts extends ListRecords
{
    protected static string $resource = AboutResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('filament.about_navigation.list');
    }
}
