<?php

namespace App\Filament\Widgets;

use App\Models\Area;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AreasDashboard extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = '場域清單';

    public function table(Table $table): Table
    {
        return $table
            ->query(Area::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('場域名稱'),
                Tables\Columns\TextColumn::make('devices_count')->label('設備數量'),
                Tables\Columns\TextColumn::make('users_count')->label('使用者數量'),
                Tables\Columns\IconColumn::make('status')->label('啟用狀態')->boolean(),
            ]);
    }
}
