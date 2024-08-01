<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Enums\DiscounType;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Filament\Resources\ProductResource\Pages\ViewProduct;
use App\Filament\Resources\ProductResource\RelationManagers\CategoriesRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\IndicationsRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\OfferRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\SideEffectsRelationManager;
use App\Models\Category;
use App\Models\Indication;
use App\Models\Product;
use App\Models\Side;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
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
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'fas-p';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Product Details')
                        ->schema([
                            Translate::make()
                                ->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->string()
                                        ->rules(['required', 'string']),
                                    Textarea::make('description')
                                        ->required()
                                        ->string()
                                        ->rules(['required', 'string']),
                                ])->locales(config('app.available_locales')),

                            SpatieMediaLibraryFileUpload::make('image')
                                ->required()
                                ->image()
                                ->rules(['image'])
                                ->collection('productImages'),

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
                    Step::make('Categories Details')
                        ->schema([
                            Select::make('categories')
                                ->label('Categories')
                                ->relationship('categories', 'name')
                                ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                                ->multiple()
                                ->required()
                                ->preload()
                                ->searchable()
                                ->hintAction(
                                    fn (Select $component) => Action::make('select all')
                                        ->action(fn () => $component->state(Category::pluck('id')->toArray()))
                                )
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->required()
                                        ->string(),
                                    SpatieMediaLibraryFileUpload::make('image')
                                        ->required()
                                        ->image()
                                        ->collection('categoryImages'),
                                ]),
                        ]),
                    Step::make('Side Effects Details')
                        ->schema([
                            Select::make('sideEffects')
                                ->label('Side Effects')
                                ->multiple()
                                ->preload()
                                ->searchable()
                                ->relationship('sideEffects', 'name')
                                ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                                ->hintAction(
                                    fn (Select $component) => Action::make('select all')
                                        ->action(fn () => $component->state(Side::pluck('id')->toArray()))
                                )
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->required()
                                        ->string()
                                        ->rules(['required', 'string']),
                                ]),
                        ]),
                    Step::make('Indications Details')
                        ->schema([
                            Select::make('indications')
                                ->label('Indications')
                                ->multiple()
                                ->preload()
                                ->searchable()
                                ->relationship('indications', 'name')
                                ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                                ->hintAction(
                                    fn (Select $component) => Action::make('select all')
                                        ->action(fn () => $component->state(Indication::pluck('id')->toArray()))
                                )
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->required()
                                        ->string()
                                        ->rules(['required', 'string']),
                                ]),
                        ]),
                    Step::make('Offer Details')
                        ->schema([
                            Select::make('Offer')
                                ->label('Offer')
                                ->preload()
                                ->searchable()
                                ->relationship('offers', 'name')
                                ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->required()
                                        ->string(),
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
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description'),
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('productImages')
                    ->width(100)
                    ->height(100),
                TextColumn::make('barcode')
                    ->searchable(),
                TextColumn::make('stock'),
                TextColumn::make('alert'),
                TextColumn::make('unit_price')
                    ->money('USD')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('no_units'),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')
                    ->fileName('Product Sheet')
                    ->defaultFormat('csv')
                    ->disableXlsx()
                    ->disableAdditionalColumns(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Product deleted')
                        ->body('The product has been deleted successfully.'),
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
            CategoriesRelationManager::class,
            SideEffectsRelationManager::class,
            IndicationsRelationManager::class,
            OfferRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'view' => ViewProduct::route('/{record}'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
