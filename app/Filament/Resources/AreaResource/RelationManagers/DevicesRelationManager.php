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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('mac_address')
                    ->required()
                    ->maxLength(30),
                Forms\Components\TextInput::make('custom_id')
                    ->required()
                    ->maxLength(30),
                Forms\Components\TextInput::make('ip')
                    ->required()
                    ->maxLength(30),
                Forms\Components\TextInput::make('ssid')
                    ->required()
                    ->maxLength(32),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('mac_address'),
                Tables\Columns\TextColumn::make('custom_id'),
                Tables\Columns\TextColumn::make('ip'),
                Tables\Columns\TextColumn::make('ssid'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AssociateAction::make()->hidden(! auth()->user()->hasRole('admin'))->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DissociateAction::make()
                    ->hidden(! auth()->user()->hasRole('admin')),
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
