<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndicationResource\Pages\CreateIndication;
use App\Filament\Resources\IndicationResource\Pages\EditIndication;
use App\Filament\Resources\IndicationResource\Pages\ListIndications;
use App\Filament\Resources\IndicationResource\Pages\ViewIndication;
use App\Filament\Resources\IndicationResource\RelationManagers\ProductsRelationManager;
use App\Models\Indication;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class IndicationResource extends Resource
{
    protected static ?string $model = Indication::class;

    protected static ?string $navigationIcon = 'fas-person-circle-check';

    protected static ?int $navigationSort = 4;

    public static function getNavigationLabel(): string
    {
        return __('filament.indication_navigation.resource');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Translate::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label(__('filament.indication_navigation.form.name'))
                            ->string(),
                    ])->locales(config('app.available_locales')),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label(__('filament.indication_navigation.table.name'))
                    ->sortable(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Indication deleted')
                            ->body('The Indication has been deleted successfully.'),
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
            ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIndications::route('/'),
            'create' => CreateIndication::route('/create'),
            'view' => ViewIndication::route('/{record}'),
            'edit' => EditIndication::route('/{record}/edit'),
        ];
    }
}
