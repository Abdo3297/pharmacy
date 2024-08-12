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
    public static function getNavigationLabel(): string
    {
        return __('filament.product_navigation.resource');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make(__('filament.product_navigation.form.info'))
                        ->schema([
                            Translate::make()
                                ->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->label(__('filament.product_navigation.form.name'))
                                        ->string()
                                        ->rules(['required', 'string']),
                                    Textarea::make('description')
                                        ->required()
                                        ->label(__('filament.product_navigation.form.desc'))
                                        ->string()
                                        ->rules(['required', 'string']),
                                ])->locales(config('app.available_locales')),

                            SpatieMediaLibraryFileUpload::make('image')
                                ->required()
                                ->label(__('filament.product_navigation.form.image'))
                                ->image()
                                ->rules(['image'])
                                ->collection('productImages'),

                            TextInput::make('barcode')
                                ->label(__('filament.product_navigation.form.barcode'))
                                ->required()
                                ->string()
                                ->rules(['required', 'string', 'size:10']),
                            TextInput::make('stock')
                            ->required()
                                ->label(__('filament.product_navigation.form.stock'))
                                ->integer()
                                ->rules(['required', 'integer']),
                            TextInput::make('alert')
                                ->required()
                                ->label(__('filament.product_navigation.form.alert'))
                                ->integer()
                                ->lt('stock')
                                ->rules(['required', 'integer']),
                            TextInput::make('unit_price')
                                ->required()
                                ->label(__('filament.product_navigation.form.unit_price'))
                                ->numeric()
                                ->minValue(0)
                                ->prefix('$')
                                ->rules(['required', 'numeric', 'min:0']),
                                TextInput::make('no_units')
                                ->required()
                                ->label(__('filament.product_navigation.form.no_units'))
                                ->integer()
                                ->minValue(1)
                                ->rules(['required', 'integer', 'min:1']),
                        ])->columns(2),
                    Step::make(__('filament.product_navigation.relation.categories.form.info'))
                        ->schema([
                            Select::make('categories')
                                ->label(__('filament.product_navigation.relation.categories.form.name'))
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
                    Step::make(__('filament.product_navigation.relation.sideffects.form.info'))
                        ->schema([
                            Select::make('sideEffects')
                                ->label(__('filament.product_navigation.relation.sideffects.form.name'))
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
                    Step::make(__('filament.product_navigation.relation.indications.form.info'))
                        ->schema([
                            Select::make('indications')
                                ->label(__('filament.product_navigation.relation.indications.form.name'))
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
                    Step::make(__('filament.product_navigation.relation.offers.form.info'))
                        ->schema([
                            Select::make('Offer')
                                ->label(__('filament.product_navigation.relation.offers.form.name'))
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
                    ->label(__('filament.product_navigation.table.name'))
                    ->sortable(),
                TextColumn::make('description')
                ->label(__('filament.product_navigation.table.desc')),
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('productImages')
                    ->label(__('filament.product_navigation.table.image'))
                    ->width(100)
                    ->height(100),
                TextColumn::make('barcode')
                ->label(__('filament.product_navigation.table.barcode'))
                    ->searchable(),
                TextColumn::make('stock')
                ->label(__('filament.product_navigation.table.stock')),
                TextColumn::make('alert')
                ->label(__('filament.product_navigation.table.alert')),
                TextColumn::make('unit_price')
                ->label(__('filament.product_navigation.table.unit_price'))
                    ->money('USD')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('no_units')
                ->label(__('filament.product_navigation.table.no_units')),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make(__('filament.product_navigation.table.export'))
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
