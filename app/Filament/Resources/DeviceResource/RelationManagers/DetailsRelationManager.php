<?php

namespace App\Filament\Resources\DeviceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    protected static ?string $title = '裝置資料';

    protected static function getModelLabel(): ?string
    {
        return '裝置資料';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('mac_address')
                    ->required()
                    ->disabled(! auth()->user()->hasAnyRole(['super_admin', 'admin']))
                    ->label('MAC位址')
                    ->maxLength(255),
                Forms\Components\TextInput::make('port')
                    ->required()
                    ->disabled(! auth()->user()->hasAnyRole(['super_admin', 'admin']))
                    ->numeric()
                    ->label('Port腳位')
                    ->minValue(1)
                    ->maxValue(8)
                    ->maxLength(30),
                Forms\Components\TextInput::make('port_name')
                    ->required()
                    ->disabled(! auth()->user()->hasAnyRole(['super_admin', 'admin']))
                    ->label('Port名稱')
                    ->maxLength(30),
                Forms\Components\Toggle::make('status')
                    ->required()
                    ->label('啟用狀態'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('mac_address')
            ->columns([
                Tables\Columns\TextColumn::make('mac_address'),
                Tables\Columns\TextColumn::make('port'),
                Tables\Columns\TextColumn::make('port_name'),
                Tables\Columns\IconColumn::make('status')->label('啟用狀態')->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->beforeFormFilled(function () {

                    }),
                // Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->before(function (Model $record, array $data) {
                        \Log::debug('after EditAction');
                        \Log::debug($record);
                        \Log::debug($data);

                        if ($record->status !== $data['status']) {
                            \Log::info('status changed');
                            // TODO: call api POST /device/control
                        }
                    }),
                // Tables\Actions\DissociateAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DissociateBulkAction::make(),
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
