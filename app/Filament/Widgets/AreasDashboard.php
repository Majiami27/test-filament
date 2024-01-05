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
            ->query(function () {
                /**
                 * @var \App\Models\User $user
                 */
                $user = auth()->user();
                $organizationId = $user?->organization_id === null ? $user?->id : $user?->organization_id;

                return Area::query()->where('organization_id', $organizationId);
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('場域名稱'),
                Tables\Columns\TextColumn::make('devices_count')->label('設備數量'),
                Tables\Columns\TextColumn::make('users_count')->label('使用者數量'),
                Tables\Columns\IconColumn::make('status')->label('啟用狀態')->boolean(),
            ]);
    }
}
