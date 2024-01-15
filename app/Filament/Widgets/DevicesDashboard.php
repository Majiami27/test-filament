<?php

namespace App\Filament\Widgets;

use App\Models\Device;
use App\Service\IotService;
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
        /**
         * @var \App\Service\IotService $iotService
         */
        $iotService = app()->make(IotService::class);
        $iotService->postDevice(auth()->user());

        return $table
            ->query(function () {
                /**
                 * @var \App\Models\User $user
                 */
                $user = auth()->user();

                if ($user->hasRole('super_admin')) {
                    return Device::query();
                }

                $organizationId = $user?->organization_id === null ? $user?->id : $user?->organization_id;

                return Device::query()->where('organization_id', $organizationId)->with('area')->orderBy('area_id', 'asc');
            })
            ->defaultSort('area_id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('area.name')
                    ->label('場域名稱')
                    ->default('待部屬'),
                Tables\Columns\TextColumn::make('mac_address')->label('MAC位址'),
                Tables\Columns\TextColumn::make('name')->label('設備名稱'),
                Tables\Columns\TextColumn::make('custom_id')->label('設備編號'),
                Tables\Columns\TextColumn::make('ip')->label('IP位址'),
                Tables\Columns\TextColumn::make('ssid')->label('SSID'),
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
            ]);
    }
}
