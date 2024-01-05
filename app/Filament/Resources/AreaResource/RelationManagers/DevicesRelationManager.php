<?php

namespace App\Filament\Resources\AreaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class DevicesRelationManager extends RelationManager
{
    protected static string $relationship = 'devices';

    protected static ?string $inverseRelationship = 'area';

    protected static ?string $title = '設備';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('mac_address')
                    ->label('MAC位址')
                    ->required()
                    ->maxLength(30),
                Forms\Components\TextInput::make('name')
                    ->label('設備名稱')
                    ->required()
                    ->maxLength(30),
                Forms\Components\TextInput::make('custom_id')
                    ->label('設備編號')
                    ->required()
                    ->maxLength(30),
                Forms\Components\TextInput::make('ip')
                    ->label('IP位址')
                    ->required()
                    ->maxLength(30),
                Forms\Components\TextInput::make('ssid')
                    ->label('SSID')
                    ->required()
                    ->maxLength(32),
                Forms\Components\Toggle::make('status')
                    ->label('啟用狀態')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('mac_address')
                    ->label('MAC位址')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('設備名稱')
                    ->searchable(),
                Tables\Columns\TextColumn::make('custom_id')
                    ->label('設備編號')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ip')
                    ->label('IP位址')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ssid')
                    ->label('SSID')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('啟用狀態')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AssociateAction::make()->hidden(! auth()->user()->hasAnyRole(['super_admin', 'admin']))->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DissociateAction::make()
                    ->hidden(! auth()->user()->hasAnyRole(['super_admin', 'admin'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DissociateBulkAction::make(),
                ]),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return true;
    }
}
