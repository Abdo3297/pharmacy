<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TermResource\Pages\CreateTerm;
use App\Filament\Resources\TermResource\Pages\EditTerm;
use App\Filament\Resources\TermResource\Pages\ListTerms;
use App\Filament\Resources\TermResource\Pages\ViewTerm;
use App\Models\Term;
use Filament\Forms\Components\Textarea;
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

class TermResource extends Resource
{
    use Translatable;

    protected static ?string $model = Term::class;

    protected static ?string $navigationIcon = 'fas-gear';

    protected static ?int $navigationSort = 12;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('FAQ Details')
                        ->schema([
                            Textarea::make('key')
                                ->required()
                                ->string(),
                            Textarea::make('value')
                                ->required()
                                ->string(),
                        ])->columns(2),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->searchable(),
                TextColumn::make('value')
                    ->searchable(),
            ])
            ->filters([
                //
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
