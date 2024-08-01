<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\Category;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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

class CategoriesRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'categories';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Category Details')
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->string(),
                            SpatieMediaLibraryFileUpload::make('image')
                                ->required()
                                ->image()
                                ->collection('categoryImages'),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('categoryImages')
                    ->width(100)
                    ->height(100),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelect(function (Select $select) {
                        return $select
                            ->multiple()
                            ->hintAction(
                                fn (Select $component) => Action::make('select all')
                                    ->action(fn () => $component->state(Category::pluck('id')->toArray()))
                            );
                    }),
                LocaleSwitcher::make(),
            ])
            ->actions([
                ViewAction::make(),
                DetachAction::make()->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Category deleted')
                        ->body('The Category has been deleted successfully.'),
                ),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
