<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Filament\Resources\UserResource\RelationManagers\FavouritesRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\OrdersRelationManager;
use App\Filament\Resources\UserResource\Widgets\UserOrdersFavs;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'fas-users';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('filament.user_navigation .resource');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make(__('filament.user_navigation .form.info'))
                        ->schema([
                            Section::make()
                                ->schema([
                                    TextInput::make('name')->label(__('filament.user_navigation .form.name')),
                                    TextInput::make('email')->label(__('filament.user_navigation .form.email')),
                                    TextInput::make('phone')->label(__('filament.user_navigation .form.phone')),
                                    TextInput::make('gender')->label(__('filament.user_navigation .form.gender')),
                                ])->columns(2),
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
                    ->label(__('filament.user_navigation .table.name'))
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('filament.user_navigation .table.email'))
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__('filament.user_navigation .table.phone'))
                    ->searchable(),
                TextColumn::make('gender')
                    ->label(__('filament.user_navigation .table.gender')),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('is_admin', false);
            })
            ->headerActions([
                FilamentExportHeaderAction::make(__('filament.user_navigation .table.export'))
                    ->fileName('User Sheet')
                    ->defaultFormat('csv')
                    ->disableXlsx()
                    ->disableAdditionalColumns(),
            ])
            ->actions([
                ViewAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            OrdersRelationManager::class,
            FavouritesRelationManager::class,
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
            'index' => ListUsers::route('/'),
            'view' => ViewUser::route('/{record}'),
        ];
    }
}
