<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages\EditAbout;
use App\Filament\Resources\AboutResource\Pages\ListAbouts;
use App\Filament\Resources\AboutResource\Pages\ViewAbout;
use App\Models\About;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;

    protected static ?string $navigationIcon = 'fas-address-card';

    protected static ?int $navigationSort = 9;

    public static function getNavigationLabel(): string
    {
        return __('filament.about_navigation.resource');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('filament.about_navigation.form.info'))
                    ->schema([
                        Translate::make()
                            ->schema([
                                Textarea::make('content')
                                    ->label(__('filament.about_navigation.form.content'))
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
                TextColumn::make('content')
                    ->label(__('filament.about_navigation.table.content'))
                    ->searchable(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAbouts::route('/'),
            'view' => ViewAbout::route('/{record}'),
            'edit' => EditAbout::route('/{record}/edit'),
        ];
    }
}
