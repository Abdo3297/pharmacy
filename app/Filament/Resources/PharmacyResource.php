<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PharmacyResource\Pages\EditPharmacy;
use App\Filament\Resources\PharmacyResource\Pages\ListPharmacies;
use App\Filament\Resources\PharmacyResource\Pages\ViewPharmacy;
use App\Models\Pharmacy;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class PharmacyResource extends Resource
{
    protected static ?string $model = Pharmacy::class;

    protected static ?string $navigationIcon = 'fas-truck-medical';

    protected static ?int $navigationSort = 8;

    public static function getNavigationLabel(): string
    {
        return __('filament.pharmacy_navigation.resource');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('filament.pharmacy_navigation.form.p_name'))
                    ->schema([
                        Translate::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('filament.pharmacy_navigation.form.name'))
                                    ->required()
                                    ->string(),
                            ])->locales(config('app.available_locales')),
                    ]),
                Section::make(__('filament.pharmacy_navigation.form.p_logo'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('Logo')
                            ->label(__('filament.pharmacy_navigation.form.logo'))
                            ->required()
                            ->image()
                            ->collection('pharmacyLogo'),
                    ]),
                Section::make(__('filament.pharmacy_navigation.form.p_carousel'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('Carousel')
                            ->label(__('filament.pharmacy_navigation.form.carousel'))
                            ->required()
                            ->image()
                            ->multiple()
                            ->collection('pharmacyCarousel'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament.pharmacy_navigation.table.name'))
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('Logo')
                    ->label(__('filament.pharmacy_navigation.table.logo'))
                    ->collection('pharmacyLogo')
                    ->width(50)
                    ->height(50),
                SpatieMediaLibraryImageColumn::make('Carousel')
                    ->label(__('filament.pharmacy_navigation.table.carousel'))
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
