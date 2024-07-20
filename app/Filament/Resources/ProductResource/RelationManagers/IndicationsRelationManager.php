<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

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
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\RelationManagers\Concerns\Translatable;

class IndicationsRelationManager extends RelationManager
{
    use Translatable;
    protected static string $relationship = 'indications';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Indication Details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->string(),
                    ]),
                    Step::make('Products Details')
                        ->schema([
                            Select::make('products')
                                ->relationship('products', 'name')
                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                                ->preload()
                                ->multiple()
                                ->searchable()
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
                                    Section::make('Side Details')
                                        ->schema([
                                            Select::make('Side Details')
                                                ->relationship('sideEffects', 'name')
                                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                                                ->preload()
                                                ->multiple()
                                                ->required()
                                                ->searchable()
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
                ])->columnSpanFull()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\viewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Indication deleted')
                        ->body('The Indication has been deleted successfully.'),
                ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
