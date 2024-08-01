<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\Side;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class SideEffectsRelationManager extends RelationManager
{
    protected static string $relationship = 'sideEffects';

    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Translate::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->string(),
                    ])->locales(config('app.available_locales')),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelect(function (Select $select) {
                        return $select
                            ->multiple()
                            ->hintAction(
                                fn (Select $component) => Action::make('select all')
                                    ->action(fn () => $component->state(Side::pluck('id')->toArray()))
                            );
                    }),
            ])
            ->actions([
                ViewAction::make(),
                DetachAction::make()->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Side Effect deleted')
                        ->body('The Side Effect has been deleted successfully.'),
                ),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
