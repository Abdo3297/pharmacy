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
                                    TextInput::make('name'),
                                ])->locales(config('app.available_locales')),
                            Select::make('discount_type'),
                            TextInput::make('discount_value'),
                            DateTimePicker::make('start_date'),
                            DateTimePicker::make('end_date'),
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
