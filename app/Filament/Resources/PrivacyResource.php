<?php

namespace App\Filament\Resources;

use App\Models\Privacy;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\Wizard\Step;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\PrivacyResource\Pages\EditPrivacy;
use App\Filament\Resources\PrivacyResource\Pages\ViewPrivacy;
use App\Filament\Resources\PrivacyResource\Pages\CreatePrivacy;
use App\Filament\Resources\PrivacyResource\Pages\ListPrivacies;

class PrivacyResource extends Resource
{
    use Translatable;
    protected static ?string $model = Privacy::class;

    protected static ?string $navigationIcon = 'fas-lock';
    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('About Content')
                        ->schema([
                            Textarea::make('content')
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
                TextColumn::make('content')
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
