<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SideResource\Pages\CreateSide;
use App\Filament\Resources\SideResource\Pages\EditSide;
use App\Filament\Resources\SideResource\Pages\ListSides;
use App\Filament\Resources\SideResource\Pages\ViewSide;
use App\Filament\Resources\SideResource\RelationManagers\ProductsRelationManager;
use App\Models\Side;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Side deleted')
                            ->body('The Side has been deleted successfully.'),
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
            'index' => ListSides::route('/'),
            'create' => CreateSide::route('/create'),
            'view' => ViewSide::route('/{record}'),
            'edit' => EditSide::route('/{record}/edit'),
        ];
    }
}
