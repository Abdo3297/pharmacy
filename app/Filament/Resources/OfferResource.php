<?php

namespace App\Filament\Resources;

use App\Enums\DiscounType;
use App\Filament\Resources\OfferResource\Pages\CreateOffer;
use App\Filament\Resources\OfferResource\Pages\EditOffer;
use App\Filament\Resources\OfferResource\Pages\ListOffers;
use App\Filament\Resources\OfferResource\Pages\ViewOffer;
use App\Filament\Resources\OfferResource\RelationManagers\ProductsRelationManager;
use App\Models\Offer;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'fas-percent';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Offer Details')
                        ->schema([
                            Section::make()
                                ->schema([
                                    Translate::make()
                                        ->schema([
                                            TextInput::make('name')
                                                ->required()
                                                ->string(),
                                        ])->locales(config('app.available_locales')),

                                    Select::make('discount_type')
                                        ->required()
                                        ->options(DiscounType::class),
                                    TextInput::make('discount_value')
                                        ->required()
                                        ->rules(['numeric', 'max:100']),
                                    DateTimePicker::make('start_date')->required(),
                                    DateTimePicker::make('end_date')->required()->after('start_date'),
                                ]),
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
                TextColumn::make('discount_type')
                    ->searchable(),
                TextColumn::make('discount_value')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->dateTime('d-m-Y H:i:s')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->dateTime('d-m-Y H:i:s')
                    ->sortable(),

            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Offer deleted')
                            ->body('The Offer has been deleted successfully.'),
                    ),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOffers::route('/'),
            'create' => CreateOffer::route('/create'),
            'view' => ViewOffer::route('/{record}'),
            'edit' => EditOffer::route('/{record}/edit'),
        ];
    }
}
