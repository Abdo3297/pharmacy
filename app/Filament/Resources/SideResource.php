<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Side;
use Filament\Tables;
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
use App\Filament\Resources\SideResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SideResource\RelationManagers;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\SideResource\RelationManagers\ProductsRelationManager;

class SideResource extends Resource
{
    use Translatable;
    protected static ?string $model = Side::class;
    protected static ?string $navigationLabel = 'Side Effects';
    protected static ?string $navigationIcon = 'fas-person-circle-exclamation';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Side Details')
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->string(),
                        ]),
                    Step::make('Product Details')
                        ->schema([
                            Select::make('product_id')
                                ->relationship('products', 'name')
                                ->multiple()
                                ->searchable()
                                ->preload()
                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                                ->hintAction(
                                    fn(Select $component) => Action::make('select all')
                                        ->action(fn() => $component->state(Product::pluck('id')->toArray()))
                                )
                                ->createOptionForm([
                                    Section::make('Product Details')
                                        ->schema([
                                            TextInput::make('name')
                                                ->required()
                                                ->string()
                                                ->rules(['required', 'string']),
                                            Textarea::make('description')
                                                ->required()
                                                ->string()
                                                ->rules(['required', 'string']),
                                            SpatieMediaLibraryFileUpload::make('image')
                                                ->required()
                                                ->image()
                                                ->rules(['image'])
                                                ->collection('productImages'),
                                            TextInput::make('barcode')
                                                ->required()
                                                ->string()
                                                ->rules(['required', 'string', 'size:10']),
                                        ])->collapsible(),
                                    Section::make('Product Store')
                                        ->schema([
                                            TextInput::make('stock')
                                                ->required()
                                                ->integer()
                                                ->rules(['required', 'integer']),
                                            TextInput::make('alert')
                                                ->required()
                                                ->integer()
                                                ->lt('stock')
                                                ->rules(['required', 'integer']),
                                        ])->collapsible(),
                                    Section::make('Product Price')
                                        ->schema([
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
                                        ])->collapsible(),
                                    Section::make('Categories')
                                        ->schema([
                                            Select::make('Categories')
                                                ->relationship('categories', 'name')
                                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                                                ->preload()
                                                ->multiple()
                                                ->required()
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
                                        ])->collapsible(),
                                    Section::make('Indications')
                                        ->schema([
                                            Select::make('Indications')
                                                ->relationship('indications', 'name')
                                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                                                ->preload()
                                                ->multiple()
                                                ->required()
                                                ->searchable()
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
                                        ])->collapsible(),
                                        Section::make('Offers')
                                        ->schema([
                                            Select::make('Offers')
                                                ->relationship('offers', 'name')
                                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                                                ->preload()
                                                ->searchable()
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
                                        ])->collapsible(),
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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Side deleted')
                            ->body('The Side has been deleted successfully.'),
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
            ProductsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSides::route('/'),
            'create' => Pages\CreateSide::route('/create'),
            'view' => Pages\ViewSide::route('/{record}'),
            'edit' => Pages\EditSide::route('/{record}/edit'),
        ];
    }
}
