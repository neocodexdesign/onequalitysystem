<?php

namespace App\Filament\Resources;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;

use App\Models\Order;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Buildings Manager';

    public static function form(Form $form): Form
    {
        
        return $form
            ->schema([
                Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\TextInput::make('unit'),
                    Forms\Components\TextInput::make('status'),
                    Forms\Components\DatePicker::make('service_date'),
                ]),

                Forms\Components\Textarea::make('description'),
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Select::make('service_id')
                            ->relationship('service', 'name_order')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name_order')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Select::make('teamleader_id')
                            ->relationship('teamleader', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                Toggle::make('receive_email')
                                    ->onColor('success')
                                    ->offColor('danger'),
                                Toggle::make('receive_sms')
                                    ->onColor('success')
                                    ->offColor('danger'),
                                Toggle::make('receive_app')
                                    ->onColor('success')
                                    ->offColor('danger'),
                            ]),
                    ]),
                

                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('building_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit')
                    ->sortable(),

                Tables\Columns\TextColumn::make('service_date')
                    ->getStateUsing(function ($record) {
                        // Assuming 'service_date' is a field in your model
                        $date = new \DateTime($record->service_date); // Convert to DateTime object
                        return $date->format('d/m/Y'); // Format the date
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('service_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('service_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
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
            /*
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Import'),
            ])*/
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

   


}
