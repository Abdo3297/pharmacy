<?php

namespace App\Filament\Resources\OfferResource\RelationManagers;

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
use Filament\Resources\RelationManagers\Concerns\Translatable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Actions\LocaleSwitcher;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Product Details')
                        ->schema([
                            Textarea::make('description'),
                            SpatieMediaLibraryFileUpload::make('image')->collection('productImages'),
                            TextInput::make('name'),
                            TextInput::make('barcode')
                                ->required()
                                ->string()
                                ->rules(['required', 'string', 'size:10']),
                            TextInput::make('stock')
                                ->required()
                                ->integer()
                                ->rules(['required', 'integer']),
                            TextInput::make('alert')
                                ->required()
                                ->integer()
                                ->lt('stock')
                                ->rules(['required', 'integer']),
                            TextInput::make('unit_price')
                                ->required()
                                ->numeric()
                                ->minValue(0)
                                ->prefix('$')
                                ->rules(['required', 'numeric', 'min:0']),
                            TextInput::make('no_units')
                                ->required()
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
                TextColumn::make('name'),
                TextColumn::make('description'),
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('productImages')
                    ->width(100)
                    ->height(100),
                TextColumn::make('barcode'),
                TextColumn::make('stock'),
                TextColumn::make('alert'),
                TextColumn::make('unit_price')->money('USD'),
                TextColumn::make('no_units'),
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
                LocaleSwitcher::make(),
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
