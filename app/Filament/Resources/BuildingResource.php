<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BuildingResource\Pages;
use App\Filament\Resources\BuildingResource\RelationManagers;
use App\Models\Building;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Mail;

use Filament\Forms\Components\Tabs;

use Filament\Forms\Components\Section;
use Nette\Schema\Schema;


class BuildingResource extends Resource
{

    protected static ?string $model = Building::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationGroup = 'Buidings x Administration';

    public static function getNavigationBadge(): string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')->ColumnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('Database')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('phone')
                                            ->tel()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('website')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('address')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('city')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('zip')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('state')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('country')
                                            ->maxLength(255),
                                        Forms\Components\FileUpload::make('image')
                                            ->image()
                                            ->directory('buildings')
                                            ->downloadable(),
                                    ])
                            ]),

                        Tabs\Tab::make('Staff')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Forms\Components\Select::make('property_id')
                                            ->relationship('property', 'name')
                                            ->searchable()
                                            ->preload()
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
                                        Forms\Components\Select::make('assistant_id')
                                            ->relationship('assistant', 'name')
                                            ->searchable()
                                            ->preload()

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

                                        Forms\Components\Select::make('maintenance_id')
                                            ->relationship('maintenance', 'name')
                                            ->searchable()
                                            ->preload()

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

                                        Forms\Components\Select::make('technician_id')
                                            ->relationship('technician', 'name')
                                            ->searchable()
                                            ->preload()

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

                                    ])
                            ]),

                        Tabs\Tab::make('Contract')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Forms\Components\FileUpload::make('contract')
                                            ->multiple(),
                                        Forms\Components\Select::make('wwdpay_id')
                                            ->relationship('wwdpay', 'description')
                                            ->searchable()
                                            ->preload()

                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('description')
                                                    ->required()
                                                    ->maxLength(255),
                                            ]),
                                    ])->columnSpan(span: 'full')

                            ]),


                        Tabs\Tab::make('Contract')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Forms\Components\FileUpload::make('contract')
                                            ->multiple(),
                                        Forms\Components\TextInput::make('name_wwd')
                                            ->required()
                                            ->maxLength(255),
                                    ])->columnSpan(span: 'full')

                            ]),
                    ]),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
            ])
            
            ->actions([
                Tables\Actions\Action::make('print')
                    ->url(function ($record) {
                        // Aqui você decodifica o contrato do JSON se ele for uma string,
                        // caso contrário, usa diretamente se for um array
                        $filePaths = is_string($record->contract) ? json_decode($record->contract, true) : $record->contract;
                        $filePath = is_array($filePaths) ? $filePaths[0] : " ";
                        // Gera a URL para a rota desejada com o parâmetro necessário
                        return route('proposals.printContract', ['contract' => $filePath]);
                    })
                    ->label('Contrato')
                    ->icon('heroicon-o-printer'), // Exemplo de ícone, ajuste conforme sua UI

                Tables\Actions\Action::make('print2')
                    ->url(function ($record) {
                        // Supondo que $record seja uma instância de Building
                        // e que cada Building tem um relacionamento 'proposals' que retorna suas Proposals
                        $proposalId = $record->proposals->first()->id ?? null;
                        if ($proposalId) {
                            return route('proposals.print', ['proposal' => $proposalId]);
                        }
                    })
                    ->label('Proposals')
                    ->icon('heroicon-o-printer')
                    ->openUrlInNewTab(),
               
                Tables\Actions\Action::make('calendar')
                    ->url(function ($record) {
                        // Supondo que $record seja uma instância de Building
                        // e que cada Building tem um relacionamento 'proposals' que retorna suas Proposals
                        $proposalId = $record->proposals->first()->id ?? null;
                        if ($proposalId) {
                            return route('proposals.tabelaPreco', ['proposal' => $proposalId]);
                        }
                    })
                    ->label('Prices')
                    ->icon('heroicon-o-printer')
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('print')
                    ->label('Imprimir')
                    ->url(route('buildings.print'))  // Esta rota deve ser definida no seu web.php
                    ->icon('heroicon-o-printer'),  // Ícone de impressora (opcional)
            ])
            ->headerActions([
                Tables\Actions\Action::make('print')
                ->label('Imprimir')
                ->url(route('buildings.print'))  // Esta rota deve ser definida no seu web.php
                ->icon('heroicon-o-printer'),  // Ícone de impressora (opcional)
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
            'index' => Pages\ListBuildings::route('/'),
            'create' => Pages\CreateBuilding::route('/create'),
            'edit' => Pages\EditBuilding::route('/{record}/edit'),
        ];
    }
}
