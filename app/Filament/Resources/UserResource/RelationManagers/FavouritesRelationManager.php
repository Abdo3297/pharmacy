<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\RelationManagers\Concerns\Translatable;

class FavouritesRelationManager extends RelationManager
{
    use Translatable;
    protected static string $relationship = 'favourites';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Product Details')
                        ->schema([
                            Section::make()
                                ->schema([
                                    Textarea::make('description'),
                                    SpatieMediaLibraryFileUpload::make('image')->collection('productImages'),
                                    TextInput::make('name'),
                                    TextInput::make('barcode'),
                                    TextInput::make('stock'),
                                    TextInput::make('alert'),
                                    TextInput::make('unit_price')->prefix('$'),
                                    TextInput::make('no_units'),
                                ]),
                        ]),
                    Step::make('Categories Details')
                        ->schema([
                            Select::make('categories')
                                ->label('Categories')
                                ->relationship('categories', 'name')
                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                                ->multiple()
                        ]),
                    Step::make('Side Effects Details')
                        ->schema([
                            Select::make('sideEffects')
                                ->label('Side Effects')
                                ->relationship('sideEffects', 'name')
                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                                ->multiple()
                        ]),
                    Step::make('Indications Details')
                        ->schema([
                            Select::make('indications')
                                ->label('Indications')
                                ->relationship('indications', 'name')
                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                                ->multiple()
                        ]),
                    Step::make('Offer Details')
                        ->schema([
                            Select::make('Offer')
                                ->label('Offer')
                                ->relationship('offers', 'name')
                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                        ]),
                ])->columnSpanFull()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('description'),
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('productImages')
                    ->width(100)
                    ->height(100),
                TextColumn::make('barcode'),
                TextColumn::make('stock'),
                TextColumn::make('alert'),
                TextColumn::make('unit_price')->money('USD'),
                TextColumn::make('no_units'),
            ])
            ->actions([
                ViewAction::make(),
            ]);
    }
}
