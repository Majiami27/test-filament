<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceResource\Pages;
use App\Filament\Resources\DeviceResource\RelationManagers\DetailsRelationManager;
use App\Models\Device;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = '裝置管理';

    protected static ?string $modelLabel = '裝置';

    protected static ?string $pluralModelLabel = '裝置管理';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        /**
         * @var \App\Models\User $user
         */
        $user = auth()->user();
        $organizationId = $user?->organization_id === null ? $user?->id : $user?->organization_id;

        return parent::getEloquentQuery()->where('organization_id', $organizationId);
    }

    public static function form(Form $form): Form
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
                Forms\Components\TextInput::make('area_id')
                    ->label('場域ID')
                    ->numeric(),
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

    public static function table(Table $table): Table
    {
        return $table
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
                Tables\Columns\TextColumn::make('area_id')
                    ->label('場域 ID')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip')
                    ->label('IP位址')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ssid')
                    ->label('SSID')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('啟用狀態')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('建立日期')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('最後更新時間')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            DetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }
}
