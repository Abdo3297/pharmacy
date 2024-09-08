<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TermResource\Pages\CreateTerm;
use App\Filament\Resources\TermResource\Pages\EditTerm;
use App\Filament\Resources\TermResource\Pages\ListTerms;
use App\Filament\Resources\TermResource\Pages\ViewTerm;
use App\Models\Term;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
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

class TermResource extends Resource
{
    protected static ?string $model = Term::class;

    protected static ?string $navigationIcon = 'fas-gear';

    protected static ?int $navigationSort = 12;

    public static function getNavigationLabel(): string
    {
        return __('filament.term_navigation.resource');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('filament.term_navigation.form.info'))
                    ->schema([
                        Translate::make()
                            ->schema([
                                Textarea::make('key')
                                    ->label(__('filament.term_navigation.form.key'))
                                    ->required()
                                    ->string(),
                                Textarea::make('value')
                                    ->label(__('filament.term_navigation.form.value'))
                                    ->required()
                                    ->string(),
                            ])->locales(config('app.available_locales')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label(__('filament.term_navigation.table.key'))
                    ->searchable(),
                TextColumn::make('value')
                    ->label(__('filament.term_navigation.table.value'))
                    ->searchable(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Term deleted')
                            ->body('The Term has been deleted successfully.'),
                    ),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTerms::route('/'),
            'create' => CreateTerm::route('/create'),
            'view' => ViewTerm::route('/{record}'),
            'edit' => EditTerm::route('/{record}/edit'),
        ];
    }
}
