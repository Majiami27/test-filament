<?php

namespace App\Filament\Widgets;

use App\Models\Device;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class DevicesDashboard extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = '設備清單';

    public function table(Table $table): Table
    {
        return $table
            ->query(Device::query())
            ->defaultSort('area_id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('mac_address')->label('MAC位址'),
                Tables\Columns\TextColumn::make('name')->label('設備名稱'),
                Tables\Columns\TextColumn::make('custom_id')->label('設備編號'),
                Tables\Columns\TextColumn::make('area_id')->label('場域 ID'),
                Tables\Columns\TextColumn::make('ip')->label('IP位址'),
                Tables\Columns\TextColumn::make('ssid')->label('SSID'),
                Tables\Columns\IconColumn::make('status')->label('啟用狀態')->boolean(),
            ]);
    }
}
