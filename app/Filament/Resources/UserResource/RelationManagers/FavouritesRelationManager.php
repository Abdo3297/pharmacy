<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class FavouritesRelationManager extends RelationManager
{
    protected static string $relationship = 'favourites';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make(__('filament.user_navigation.relation.favourites.form.info'))
                        ->schema([
                            Section::make()
                                ->schema([
                                    Translate::make()
                                        ->schema([
                                            TextInput::make('name')
                                                ->label(__('filament.user_navigation.relation.favourites.form.name')),
                                            Textarea::make('description')
                                                ->label(__('filament.user_navigation.relation.favourites.form.description')),
                                        ])->locales(config('app.available_locales')),
                                    SpatieMediaLibraryFileUpload::make('image')
                                        ->label(__('filament.user_navigation.relation.favourites.form.image'))
                                        ->collection('productImages'),
                                    TextInput::make('barcode')
                                        ->label(__('filament.user_navigation.relation.favourites.form.barcode')),
                                    TextInput::make('stock')
                                        ->label(__('filament.user_navigation.relation.favourites.form.stock')),
                                    TextInput::make('alert')
                                        ->label(__('filament.user_navigation.relation.favourites.form.alert')),
                                    TextInput::make('unit_price')
                                        ->label(__('filament.user_navigation.relation.favourites.form.unit_price'))
                                        ->prefix('$'),
                                    TextInput::make('no_units')
                                        ->label(__('filament.user_navigation.relation.favourites.form.no_units')),
                                ]),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament.user_navigation.relation.favourites.table.name')),
                TextColumn::make('description')
                    ->label(__('filament.user_navigation.relation.favourites.table.description')),
                SpatieMediaLibraryImageColumn::make('image')
                    ->label(__('filament.user_navigation.relation.favourites.table.image'))
                    ->collection('productImages')
                    ->width(100)
                    ->height(100),
                TextColumn::make('barcode')
                    ->label(__('filament.user_navigation.relation.favourites.table.barcode')),
                TextColumn::make('stock')
                    ->label(__('filament.user_navigation.relation.favourites.table.stock')),
                TextColumn::make('alert')
                    ->label(__('filament.user_navigation.relation.favourites.table.alert')),
                TextColumn::make('unit_price')
                    ->label(__('filament.user_navigation.relation.favourites.table.unit_price'))
                    ->money('USD'),
                TextColumn::make('no_units')
                    ->label(__('filament.user_navigation.relation.favourites.table.no_units')),
            ])
            ->actions([
                ViewAction::make(),
            ]);
    }
}
