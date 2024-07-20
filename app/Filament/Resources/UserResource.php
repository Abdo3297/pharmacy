<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\Widgets\UserOrdersFavs;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\UserResource\RelationManagers\OrdersRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\FavouritesRelationManager;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'fas-users';
    protected static ?string $navigationGroup = 'Customers';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('User Details')
                        ->schema([
                            Section::make()
                                ->schema([
                                    TextInput::make('name'),
                                    TextInput::make('email'),
                                    TextInput::make('phone'),
                                    TextInput::make('gender'),
                                ])->columns(2),
                        ]),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('gender')
                    ->searchable(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('is_admin', false);
            })
            ->filters([
                //
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')
                    ->fileName('User Sheet')
                    ->defaultFormat('csv')
                    ->disableXlsx()
                    ->disableAdditionalColumns()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
            ]);
    }

    public static function getRelations(): array
    {
        return [
            OrdersRelationManager::class,
            FavouritesRelationManager::class
        ];
    }
    public static function getWidgets(): array
    {
        return [
            UserOrdersFavs::class,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
