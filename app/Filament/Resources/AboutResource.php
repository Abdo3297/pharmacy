<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\About;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Concerns\Translatable;
use App\Filament\Resources\AboutResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AboutResource\RelationManagers;
use Filament\Forms\Components\Textarea;

class AboutResource extends Resource
{
    use Translatable;
    protected static ?string $model = About::class;

    protected static ?string $navigationIcon = 'fas-address-card';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 9;

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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbouts::route('/'),
            'view' => Pages\ViewAbout::route('/{record}'),
            'edit' => Pages\EditAbout::route('/{record}/edit'),
        ];
    }
}
