<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\OrderResource\RelationManagers\ProductsRelationManager;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'fas-cart-shopping';
    protected static ?string $navigationGroup = 'Orders';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Order Details')
                        ->schema([
                            Section::make()
                                ->schema([
                                    Select::make('user_id')
                                        ->relationship('user', 'name'),
                                    TextInput::make('total_amount')->prefix('$'),
                                    TextInput::make('payment_type'),
                                    TextInput::make('payment_id'),
                                    ToggleButtons::make('payment_status')->boolean()->inline()
                                ]),
                        ]),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('total_amount')
                    ->money('USD')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('payment_id')
                    ->searchable(),
                IconColumn::make('payment_status')
                    ->boolean(),
                TextColumn::make('payment_type')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')
                    ->fileName('Orders Sheet')
                    ->defaultFormat('csv')
                    ->disableXlsx()
                    ->disableAdditionalColumns()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
