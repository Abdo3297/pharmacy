<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Tables;
use Filament\Forms\Form;
use App\Enums\DiscounType;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\DateTimePicker;
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
                                    Textarea::make('description')
                                        ->required()
                                        ->string()
                                        ->rules(['required', 'string']),
                                    SpatieMediaLibraryFileUpload::make('image')
                                        ->required()
                                        ->image()
                                        ->rules(['image'])
                                        ->collection('productImages'),
                                    TextInput::make('name')
                                        ->required()
                                        ->string()
                                        ->rules(['required', 'string']),
                                    TextInput::make('barcode')
                                        ->required()
                                        ->string()
                                        ->rules(['required', 'string', 'size:10']),
                                    TextInput::make('stock')
                                        ->required()
                                        ->integer()
                                        ->rules(['required', 'integer']),
                                    TextInput::make('alert')
                                        ->required()
                                        ->integer()
                                        ->lt('stock')
                                        ->rules(['required', 'integer']),
                                    TextInput::make('unit_price')
                                        ->required()
                                        ->numeric()
                                        ->minValue(0)
                                        ->prefix('$')
                                        ->rules(['required', 'numeric', 'min:0']),
                                    TextInput::make('no_units')
                                        ->required()
                                        ->integer()
                                        ->minValue(1)
                                        ->rules(['required', 'integer', 'min:1']),
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
                Tables\Actions\ViewAction::make(),
            ]);
    }
}
