<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProposalResource\Pages;
use App\Filament\Resources\ProposalResource\RelationManagers;
use App\Models\Proposal;
use App\Models\Item;
use App\Models\Service;

use Doctrine\DBAL\Schema\Column;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\LinkAction;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\MarkdownEditor;

use Filament\Forms\Components\Columns;
use Filament\Forms\Components\TextInput;

use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Nette\Schema\Schema;

class ProposalResource extends Resource
{
    protected static ?string $model = Proposal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Buildings Manager';

    public static function form(Form $form): Form
    {

        return $form

            ->schema([
                Tabs::make('Tabs')->ColumnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('Cover')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Forms\Components\Select::make('building_id')
                                            ->relationship('building', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->required()
                                                    ->maxLength(255),
                                            ]),
                                        Forms\Components\TextInput::make('titulo_geral')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('contact')
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\FileUpload::make('logo_cover')
                                            ->image(),

                                        Forms\Components\FileUpload::make('image_cover')
                                            ->image(),
                                        /*
                                        Forms\Components\TextInput::make('titulo_images')
                                            ->maxLength(255),

                                        Forms\Components\FileUpload::make('images')
                                            ->image()
                                            ->multiple(),*/
                                    ])
                            ]),
                        Tabs\Tab::make('Detail')
                            ->schema([
                                Section::make()
                                    ->schema([

                                        Forms\Components\TextInput::make('titulo_description')
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\RichEditor::make('description')
                                            ->autofocus() // Autofocus the field.
                                            ->enableToolbarButtons($buttons = []) // Enable toolbar buttons. See below for options.
                                            ->maxLength(65535)
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('addition_description')
                                            ->required()
                                            ->enableToolbarButtons($buttons = []) // Enable toolbar buttons. See below for options.
                                            ->maxLength(65535)
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('additional_notes')
                                            ->required()
                                            ->enableToolbarButtons($buttons = []) // Enable toolbar buttons. See below for options.
                                            ->maxLength(65535)
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('thanks')
                                            ->required()
                                            ->enableToolbarButtons($buttons = []) // Enable toolbar buttons. See below for options.
                                            ->maxLength(65535)
                                            ->columnSpanFull(),
                                    ])
                            ]),

                        Tabs\Tab::make('Estimate')
                            ->schema([
                                Forms\Components\Placeholder::make(name: 'Items'),
                                Forms\Components\Repeater::make(name: 'Item_Proposal')
                                    ->Relationship()
                                    ->Schema([
                                        Forms\Components\Select::make(name: 'item_id')
                                            ->label(label: 'Item')
                                            ->options(Item::query()->pluck(column: 'name', key: 'id'))
                                            ->required()
                                            ->reactive()
                                            ->columnSpan(['md' => 4]),
                                        Forms\Components\Select::make(name: 'service_id')
                                            ->label(label: 'Service')
                                            ->options(Service::query()->pluck(column: 'name', key: 'id'))
                                            ->required()
                                            ->reactive()
                                            ->columnSpan(['md' => 4]),
                                        Forms\Components\TextInput::make(name: 'value')
                                            ->numeric()
                                            ->required()
                                            ->columnSpan(['md' => 2]),
                                    ])
                                    ->defaultItems(count: 1)
                                    ->columns([
                                        'md' => 10,

                                    ])
                            ])

                    ])->columnSpan(span: 'full')

            ]);
    }




    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('building_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('titulo_geral')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_cover'),
                Tables\Columns\TextColumn::make('titulo_images')
                    ->searchable(),
                Tables\Columns\TextColumn::make('titulo_description')
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
            ->actions([
                Tables\Actions\Action::make('print')
                    ->url(fn ($record): string => route('proposals.print', $record))
                    ->icon('heroicon-o-printer')
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('tabelaPreco')
                    ->url(fn ($record): string => route('proposals.tabelaPreco', $record))
                    ->icon('heroicon-o-printer')
                    ->openUrlInNewTab(),

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
            'index' => Pages\ListProposals::route('/'),
            'create' => Pages\CreateProposal::route('/create'),
            'edit' => Pages\EditProposal::route('/{record}/edit'),
        ];
    }
}
