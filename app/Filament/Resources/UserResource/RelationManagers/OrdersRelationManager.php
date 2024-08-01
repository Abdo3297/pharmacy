<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Order Details')
                        ->schema([
                            Section::make()
                                ->schema([
                                    TextInput::make('total_amount')->prefix('$'),
                                    TextInput::make('payment_type'),
                                    TextInput::make('payment_id'),
                                    ToggleButtons::make('payment_status')->boolean()->inline(),
                                ])->columns(2),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('total_amount')->prefix('$'),
                TextColumn::make('payment_id'),
                TextColumn::make('payment_type'),
                IconColumn::make('payment_status')->boolean(),
            ])
            ->actions([
                ViewAction::make(),
            ]);
    }
}
