<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PharmacyResource\Pages\EditPharmacy;
use App\Filament\Resources\PharmacyResource\Pages\ListPharmacies;
use App\Filament\Resources\PharmacyResource\Pages\ViewPharmacy;
use App\Models\Pharmacy;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PharmacyResource extends Resource
{
    protected static ?string $model = Pharmacy::class;

    protected static ?string $navigationIcon = 'fas-truck-medical';

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Pharmacy Name')
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->string(),
                        ]),
                    Step::make('Pharmacy Logo')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('Logo')
                                ->required()
                                ->image()
                                ->collection('pharmacyLogo'),
                        ]),
                    Step::make('Pharmacy Carousel')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('Carousel')
                                ->required()
                                ->image()
                                ->multiple()
                                ->collection('pharmacyCarousel'),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('Logo')
                    ->collection('pharmacyLogo')
                    ->width(50)
                    ->height(50),
                SpatieMediaLibraryImageColumn::make('Carousel')
                    ->collection('pharmacyCarousel')
                    ->width(50)
                    ->height(50),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPharmacies::route('/'),
            'view' => ViewPharmacy::route('/{record}'),
            'edit' => EditPharmacy::route('/{record}/edit'),
        ];
    }
}
