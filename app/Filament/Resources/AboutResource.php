<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages\EditAbout;
use App\Filament\Resources\AboutResource\Pages\ListAbouts;
use App\Filament\Resources\AboutResource\Pages\ViewAbout;
use App\Models\About;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AboutResource extends Resource
{
    use Translatable;

    protected static ?string $model = About::class;

    protected static ?string $navigationIcon = 'fas-address-card';

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
