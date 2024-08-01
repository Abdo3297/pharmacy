<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\Concerns\Translatable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\LocaleSwitcher;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsRelationManager extends RelationManager
{
    use Translatable;

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
                                    TextInput::make('name'),
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
            ->headerActions([
                LocaleSwitcher::make(),
            ])
            ->actions([
                ViewAction::make(),
            ]);
    }
}
