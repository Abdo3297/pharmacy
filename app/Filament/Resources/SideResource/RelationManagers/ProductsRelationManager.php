<?php

namespace App\Filament\Resources\SideResource\RelationManagers;

use App\Models\Product;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make(__('filament.side_navigation.relation.products.form.info'))
                        ->schema([
                            Translate::make()
                                ->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->label(__('filament.side_navigation.relation.products.form.name'))
                                        ->string()
                                        ->rules(['required', 'string']),
                                    Textarea::make('description')
                                        ->required()
                                        ->label(__('filament.side_navigation.relation.products.form.desc'))
                                        ->string()
                                        ->rules(['required', 'string']),
                                ])->locales(config('app.available_locales')),
                            SpatieMediaLibraryFileUpload::make('image')
                                ->required()
                                ->label(__('filament.side_navigation.relation.products.form.image'))
                                ->image()
                                ->rules(['image'])
                                ->collection('productImages'),

                            TextInput::make('barcode')
                                ->required()
                                ->label(__('filament.side_navigation.relation.products.form.barcode'))
                                ->string()
                                ->rules(['required', 'string', 'size:10']),
                            TextInput::make('stock')
                                ->required()
                                ->label(__('filament.side_navigation.relation.products.form.stock'))
                                ->integer()
                                ->rules(['required', 'integer']),
                            TextInput::make('alert')
                                ->required()
                                ->label(__('filament.side_navigation.relation.products.form.alert'))
                                ->integer()
                                ->lt('stock')
                                ->rules(['required', 'integer']),
                            TextInput::make('unit_price')
                                ->required()
                                ->label(__('filament.side_navigation.relation.products.form.unit_price'))
                                ->numeric()
                                ->minValue(0)
                                ->prefix(config('pharmacy.currency-prefix'))
                                ->rules(['required', 'numeric', 'min:0']),
                            TextInput::make('no_units')
                                ->required()
                                ->label(__('filament.side_navigation.relation.products.form.no_units'))
                                ->integer()
                                ->minValue(1)
                                ->rules(['required', 'integer', 'min:1']),
                        ])->columns(2),
                ])->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament.side_navigation.relation.products.table.name')),
                TextColumn::make('description')
                    ->label(__('filament.side_navigation.relation.products.table.desc')),
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('productImages')
                    ->width(100)
                    ->label(__('filament.side_navigation.relation.products.table.image'))
                    ->height(100),
                TextColumn::make('barcode')
                    ->label(__('filament.side_navigation.relation.products.table.barcode')),
                TextColumn::make('stock')
                    ->label(__('filament.side_navigation.relation.products.table.stock')),
                TextColumn::make('alert')
                    ->label(__('filament.side_navigation.relation.products.table.alert')),
                TextColumn::make('unit_price')->prefix(config('pharmacy.currency-prefix'))
                    ->label(__('filament.side_navigation.relation.products.table.unit_price')),
                TextColumn::make('no_units')
                    ->label(__('filament.side_navigation.relation.products.table.no_units')),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelect(function (Select $select) {
                        return $select
                            ->multiple()
                            ->hintAction(
                                fn (Select $component) => Action::make('select all')
                                    ->action(fn () => $component->state(Product::pluck('id')->toArray()))
                            );
                    }),
            ])
            ->actions([
                ViewAction::make(),
                DetachAction::make()->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Product deleted')
                        ->body('The product has been deleted successfully.'),
                ),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
