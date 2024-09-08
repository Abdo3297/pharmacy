<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\OrderResource\Pages\ListOrders;
use App\Filament\Resources\OrderResource\Pages\ViewOrder;
use App\Filament\Resources\OrderResource\RelationManagers\ProductsRelationManager;
use App\Models\Order;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'fas-cart-shopping';

    protected static ?int $navigationSort = 7;

    public static function getNavigationLabel(): string
    {
        return __('filament.order_navigation.resource');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make(__('filament.order_navigation.form.info'))
                    ->schema([
                        Section::make()
                            ->schema([
                                Select::make('user_id')
                                    ->label(__('filament.order_navigation.form.user'))
                                    ->relationship('user', 'name'),
                                TextInput::make('total_amount')
                                    ->label(__('filament.order_navigation.form.total_amount'))
                                    ->prefix(config('pharmacy.currency-prefix')),
                                TextInput::make('payment_type')
                                    ->label(__('filament.order_navigation.form.payment_type')),
                                TextInput::make('payment_id')
                                    ->label(__('filament.order_navigation.form.payment_id')),
                                ToggleButtons::make('payment_status')
                                    ->label(__('filament.order_navigation.form.payment_status'))
                                    ->boolean()
                                    ->inline(),
                            ]),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('filament.order_navigation.table.user')),
                TextColumn::make('total_amount')
                    ->label(__('filament.order_navigation.table.total_amount'))
                    ->prefix(config('pharmacy.currency-prefix'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('payment_id')
                    ->label(__('filament.order_navigation.table.payment_id'))
                    ->searchable(),
                IconColumn::make('payment_status')
                    ->label(__('filament.order_navigation.table.payment_status'))
                    ->boolean(),
                TextColumn::make('payment_type')
                    ->label(__('filament.order_navigation.table.payment_type'))
                    ->searchable(),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')
                    ->fileName('Orders Sheet')
                    ->defaultFormat('csv')
                    ->disableXlsx()
                    ->disableAdditionalColumns(),
            ])
            ->actions([
                ViewAction::make(),
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
            'index' => ListOrders::route('/'),
            'view' => ViewOrder::route('/{record}'),
        ];
    }
}
