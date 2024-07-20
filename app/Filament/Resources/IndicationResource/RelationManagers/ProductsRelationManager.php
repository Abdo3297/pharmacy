<?php

namespace App\Filament\Resources\IndicationResource\RelationManagers;

use Filament\Forms;
use App\Models\Side;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use App\Enums\DiscounType;
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
                                ->preload()
                                ->multiple()
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
                                ->relationship('sideEffects', 'name')
                                ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                                ->preload()
                                ->multiple()
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Product edited')
                        ->body('The product has been edited successfully.'),
                ),
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
}
