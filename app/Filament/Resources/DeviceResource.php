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

    protected static ?string $navigationLabel = '設備管理';

    // protected static ?string $modelLabel = '設備';

    // protected static ?string $pluralModelLabel = '設備管理';

    public static function getModelLabel(): string
    {
        return '設備';
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        /**
         * @var \App\Models\User $user
         */
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            return parent::getEloquentQuery();
        }

        $organizationId = $user?->organization_id === null ? $user?->id : $user?->organization_id;

        return parent::getEloquentQuery()->where('organization_id', $organizationId);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('基本資料')->schema([
                    Forms\Components\TextInput::make('mac_address')
                        ->label('MAC位址')
                        ->disabled()
                        ->required()
                        ->maxLength(30),
                    Forms\Components\TextInput::make('name')
                        ->label('設備名稱')
                        ->disabled()
                        ->required()
                        ->maxLength(30),
                    Forms\Components\TextInput::make('custom_id')
                        ->label('設備編號')
                        ->disabled()
                        ->required()
                        ->maxLength(30),
                    Forms\Components\TextInput::make('area_id')
                        ->label('場域ID')
                        ->disabled()
                        ->numeric(),
                    Forms\Components\TextInput::make('ip')
                        ->label('IP位址')
                        ->disabled()
                        ->required()
                        ->maxLength(30),
                    Forms\Components\TextInput::make('ssid')
                        ->label('SSID')
                        ->disabled()
                        ->required()
                        ->maxLength(32),
                    Forms\Components\Select::make('status')
                        ->label('狀態')
                        ->disabled()
                        ->options([
                            0 => '停用',
                            1 => '啟用',
                            2 => '等待配對',
                        ])
                        ->native(false),
                ])->columns(2),
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
                Tables\Columns\TextColumn::make('area.name')
                    ->label('場域名稱')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip')
                    ->label('IP位址')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ssid')
                    ->label('SSID')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('啟用狀態')
                    ->icon(fn (string $state): string => match ($state) {
                        '0' => 'heroicon-o-x-circle',
                        '1' => 'heroicon-o-check-circle',
                        '2' => 'heroicon-o-plus-circle',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'danger',
                        '1' => 'success',
                        '2' => 'warning',
                        default => 'gray',
                    }),
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
