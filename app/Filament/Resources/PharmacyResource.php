<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pharmacy;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Concerns\Translatable;
use App\Filament\Resources\PharmacyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\PharmacyResource\RelationManagers;
use App\Filament\Resources\PharmacyResource\Pages\EditPharmacy;
use App\Filament\Resources\PharmacyResource\Pages\ViewPharmacy;
use App\Filament\Resources\PharmacyResource\Pages\ListPharmacies;


class PharmacyResource extends Resource
{
    use Translatable;
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
