<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Order Details')
                        ->schema([
                            Section::make()
                                ->schema([
                                    Translate::make()
                                        ->schema([
                                            TextInput::make('name'),
                                        ])->locales(config('app.available_locales')),
                                    TextInput::make('quantity'),
                                    TextInput::make('unit_price')->prefix('USD'),
                                    TextInput::make('total_price')->prefix('USD'),
                                ]),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('quantity'),
                TextColumn::make('unit_price')->money('USD'),
                TextColumn::make('total_price')->money('USD'),
            ])
            ->actions([
                ViewAction::make(),
            ]);
    }
}
