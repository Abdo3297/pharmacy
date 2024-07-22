<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Side;
use Filament\Tables;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms\Form;
use App\Enums\DiscounType;
use App\Models\Indication;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Concerns\Translatable;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\ProductResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\ProductResource\RelationManagers\OfferRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\CategoriesRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\IndicationsRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\SideEffectsRelationManager;

class ProductResource extends Resource
{
    use Translatable;
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'fas-p';
    protected static ?string $navigationGroup = 'Store';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Product Details')
                        ->schema([
                            Textarea::make('description')
                                ->required()
                                ->string()
                                ->rules(['required', 'string']),
                            SpatieMediaLibraryFileUpload::make('image')
                                ->required()
                                ->image()
                                ->rules(['image'])
                                ->collection('productImages'),
                            TextInput::make('name')
                                ->required()
                                ->string()
                                ->rules(['required', 'string']),
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
                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                                ->multiple()
                                // ->required()
                                ->preload()
                                ->searchable()
                                ->hintAction(
                                    fn(Select $component) => Action::make('select all')
                                        ->action(fn() => $component->state(Category::pluck('id')->toArray()))
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
                                // ->required()
                                ->multiple()
                                ->preload()
                                ->searchable()
                                ->relationship('sideEffects', 'name')
                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                                ->hintAction(
                                    fn(Select $component) => Action::make('select all')
                                        ->action(fn() => $component->state(Side::pluck('id')->toArray()))
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
                                // ->required()
                                ->multiple()
                                ->preload()
                                ->searchable()
                                ->relationship('indications', 'name')
                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                                ->hintAction(
                                    fn(Select $component) => Action::make('select all')
                                        ->action(fn() => $component->state(Indication::pluck('id')->toArray()))
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
                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                                ->createOptionForm([
                                    Section::make('Offer Name')
                                        ->schema([
                                            TextInput::make('name')
                                                ->required()
                                                ->string(),
                                        ])->collapsible(),
                                    Section::make('Offer Discount Details')
                                        ->schema([
                                            Select::make('discount_type')
                                                ->required()
                                                ->options(DiscounType::class),
                                            TextInput::make('discount_value')
                                                ->required()
                                                ->rules(['numeric', 'max:100']),
                                        ])->collapsible(),
                                    Section::make('Offer Date Details')
                                        ->schema([
                                            DateTimePicker::make('start_date')->required(),
                                            DateTimePicker::make('end_date')->required()->after('start_date'),
                                        ])->collapsible(),
                                ]),
                        ]),
                ])->columnSpanFull()
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
            ->filters([
                //
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')
                    ->fileName('Product Sheet')
                    ->defaultFormat('csv')
                    ->disableXlsx()
                    ->disableAdditionalColumns()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Product deleted')
                        ->body('The product has been deleted successfully.'),
                ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
