<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrivacyResource\Pages\CreatePrivacy;
use App\Filament\Resources\PrivacyResource\Pages\EditPrivacy;
use App\Filament\Resources\PrivacyResource\Pages\ListPrivacies;
use App\Filament\Resources\PrivacyResource\Pages\ViewPrivacy;
use App\Models\Privacy;
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

class PrivacyResource extends Resource
{
    protected static ?string $model = Privacy::class;

    protected static ?string $navigationIcon = 'fas-lock';

    protected static ?int $navigationSort = 11;

    public static function getNavigationLabel(): string
    {
        return __('filament.privacy_navigation.resource');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Translate::make()
                    ->schema([
                        Textarea::make('content')
                            ->label(__('filament.privacy_navigation.form.content'))
                            ->required()
                            ->string(),
                    ])->locales(config('app.available_locales')),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('content')
                    ->label(__('filament.privacy_navigation.table.content'))
                    ->searchable(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Privacy deleted')
                            ->body('The Privacy has been deleted successfully.'),
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
            'index' => ListPrivacies::route('/'),
            'create' => CreatePrivacy::route('/create'),
            'view' => ViewPrivacy::route('/{record}'),
            'edit' => EditPrivacy::route('/{record}/edit'),
        ];
    }
}
