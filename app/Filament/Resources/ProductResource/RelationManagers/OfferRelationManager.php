<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class OfferRelationManager extends RelationManager
{
    protected static string $relationship = 'offers';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Offer Details')
                        ->schema([
                            Translate::make()
                                ->schema([
                                    TextInput::make('name')
                                    ->label(__('filament.product_navigation.relation.offers.form.name')),
                                ])->locales(config('app.available_locales')),
                            Select::make('discount_type')
                            ->label(__('filament.product_navigation.relation.offers.form.discount_type')),
                            TextInput::make('discount_value')
                            ->label(__('filament.product_navigation.relation.offers.form.discount_value')),
                            DateTimePicker::make('start_date')
                            ->label(__('filament.product_navigation.relation.offers.form.start_date')),
                            DateTimePicker::make('end_date')
                            ->label(__('filament.product_navigation.relation.offers.form.end_date')),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label(__('filament.product_navigation.relation.offers.table.name')),
                    TextColumn::make('discount_type')
                    ->searchable()
                    ->label(__('filament.product_navigation.relation.offers.table.discount_type')),
                TextColumn::make('discount_value')
                    ->searchable()
                    ->label(__('filament.product_navigation.relation.offers.table.discount_value')),
                TextColumn::make('start_date')
                    ->dateTime('d-m-Y H:i:s')
                    ->label(__('filament.product_navigation.relation.offers.table.start_date'))
                    ->sortable(),
                TextColumn::make('end_date')
                    ->dateTime('d-m-Y H:i:s')
                    ->sortable()
                    ->label(__('filament.product_navigation.relation.offers.table.end_date')),
            ])
            ->actions([
                ViewAction::make(),
                DetachAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Offer deleted')
                            ->body('The Offer has been deleted successfully.'),
                    ),
            ]);
    }
}
