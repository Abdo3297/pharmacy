<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Forms\Components\Wizard\Step;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\Actions\Action;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make(__('filament.category_navigation.relation.products.form.info'))
                    ->schema([
                        Translate::make()
                            ->schema([
                                TextInput::make('name')->label(__('filament.category_navigation.relation.products.form.name')),
                                Textarea::make('description')->label(__('filament.category_navigation.relation.products.form.description')),
                            ])->locales(config('app.available_locales')),

                        SpatieMediaLibraryFileUpload::make('image')->label(__('filament.category_navigation.relation.products.form.image'))->collection('productImages'),
                        TextInput::make('barcode')->label(__('filament.category_navigation.relation.products.form.barcode')),
                        TextInput::make('stock')->label(__('filament.category_navigation.relation.products.form.stock')),
                        TextInput::make('alert')->label(__('filament.category_navigation.relation.products.form.alert')),
                        TextInput::make('unit_price')->label(__('filament.category_navigation.relation.products.form.unit_price'))->prefix(config('pharmacy.currency-prefix')),
                        TextInput::make('no_units')->label(__('filament.category_navigation.relation.products.form.no_units')),
                    ])->columns(2),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->label(__('filament.category_navigation.relation.products.table.name')),
                TextColumn::make('description')->label(__('filament.category_navigation.relation.products.table.description')),
                SpatieMediaLibraryImageColumn::make('image')
                    ->label(__('filament.category_navigation.relation.products.table.image'))
                    ->collection('productImages')
                    ->width(100)
                    ->height(100),
                TextColumn::make('barcode')->label(__('filament.category_navigation.relation.products.table.barcode')),
                TextColumn::make('stock')->label(__('filament.category_navigation.relation.products.table.stock')),
                TextColumn::make('alert')->label(__('filament.category_navigation.relation.products.table.alert')),
                TextColumn::make('unit_price')->label(__('filament.category_navigation.relation.products.table.unit_price'))->prefix(config('pharmacy.currency-prefix')),
                TextColumn::make('no_units')->label(__('filament.category_navigation.relation.products.table.no_units')),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelect(function (Select $select) {
                        return $select
                            ->multiple()
                            ->options(function () {
                                return Product::whereDoesntHave('categories', function ($query) {
                                    $query->where('categories.id', $this->ownerRecord->id);
                                })->pluck('name', 'id');
                            })
                            ->hintAction(
                                fn(Select $component) => Action::make('select all')
                                    ->action(fn() => $component->state(
                                        Product::whereDoesntHave('categories', function ($query) {
                                            $query->where('categories.id', $this->ownerRecord->id);
                                        })->pluck('id')->toArray()
                                    ))
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
