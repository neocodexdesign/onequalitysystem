<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Buildings Manager';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('unit')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('paint_date'),
                Forms\Components\DateTimePicker::make('cleaning_date'),
                Forms\Components\TextInput::make('building')
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('unit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('paint_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cleaning_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('building')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])

            ->headerActions([
                Tables\Actions\CreateAction::make('New')
                    ->label('New Event'),

                Tables\Actions\CreateAction::make('Print')
                    ->label('Print')
                    ->url(route('printexcel')) // Opcional: para onde a ação deve levar o usuário. Use `url()` para uma URL arbitrária ou `route()` para uma rota nomeada.
                    ->icon('heroicon-o-printer'), // Opcional: Ícone para a ação. Certifique-se de usar um ícone disponível.

                Tables\Actions\CreateAction::make('Orders')
                    ->label('Export to Orders')
                    ->url(route('exportorder')) // Opcional: para onde a ação deve levar o usuário. Use `url()` para uma URL arbitrária ou `route()` para uma rota nomeada.
                    ->icon('heroicon-o-printer'), // Opcional: Ícone para a ação. Certifique-se de usar um ícone disponível.

                Tables\Actions\Action::make('import') // 'newAction' é um identificador único para a ação
                    ->label('Expor to Calendar') // O texto que será exibido para o usuário
                    ->url(route('exportcalendar')), // Opcional: para onde a ação deve levar o usuário. Use `url()` para uma URL arbitrária ou `route()` para uma rota nomeada.
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
