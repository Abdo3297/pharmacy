<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pharmacy;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPharmacies::route('/'),
            'view' => Pages\ViewPharmacy::route('/{record}'),
            'edit' => Pages\EditPharmacy::route('/{record}/edit'),
        ];
    }
}
