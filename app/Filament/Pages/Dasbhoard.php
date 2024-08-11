<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make(__('filament.main_page.filter.info'))->schema([
                DatePicker::make('startDate')->label(__('filament.main_page.filter.start')),
                DatePicker::make('endDate')->label(__('filament.main_page.filter.end')),
            ])->collapsible()->columns(2),
        ]);
    }
}
