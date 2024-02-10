<?php

namespace App\Filament\Resources\AreaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
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
                    ->filled()
                    ->maxLength(30),
                Forms\Components\TextInput::make('custom_id')
                    ->label('設備編號')
                    ->filled()
                    ->maxLength(30),
                Forms\Components\TextInput::make('ip')
                    ->label('IP位址')
                    ->nullable()
                    ->maxLength(30),
                Forms\Components\TextInput::make('ssid')
                    ->label('SSID')
                    ->nullable()
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
                Tables\Actions\AssociateAction::make()
                    ->hidden(! auth()->user()->hasAnyRole(['super_admin', 'admin']))
                    ->recordSelectOptionsQuery(function (Builder $query) {
                        /**
                         * @var \App\Models\User $user
                         */
                        $user = auth()->user();

                        if ($user->hasRole('super_admin')) {
                            // TODO: 應該是選擇該組織的設備
                            return $query;
                        }

                        return $query->where('organization_id', '=', $user->id);
                    })
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\Section::make([
                            Forms\Components\Repeater::make('details')
                                ->relationship()
                                ->addable(false)
                                ->deletable(false)
                                ->schema([
                                    Forms\Components\Toggle::make('status')
                                        ->label('狀態')
                                        ->live()
                                        ->afterStateUpdated(function (?string $state, ?string $old, Model $record) {
                                            $record->status = (bool) $state;
                                            $record->save();

                                            $ports = $record->device->details;

                                            $action = $ports->pluck('status', 'port')->toArray();

                                            /**
                                             * @var \App\Service\IotService $iotService
                                             */
                                            $iotService = app(\App\Service\IotService::class);
                                            $iotService->postDeviceControl(auth()->user(), $record->mac_address, $action);
                                        })

                                        ->required(),
                                ])
                                ->itemLabel(fn (array $state): ?string => 'Port '.$state['port'] ?? null)
                                ->columns(3)
                                ->grid(2)
                                ->label('詳細資料')
                                ->collapsible(false),
                        ]),
                        Forms\Components\Section::make([
                            Forms\Components\TextInput::make('mac_address')
                                ->label('MAC位址')
                                ->disabled()
                                ->filled()
                                ->maxLength(30),
                            Forms\Components\TextInput::make('name')
                                ->label('設備名稱')
                                ->filled()
                                ->default('')
                                ->maxLength(30),
                            Forms\Components\TextInput::make('custom_id')
                                ->label('設備編號')
                                ->nullable()
                                ->maxLength(30),
                            Forms\Components\TextInput::make('ip')
                                ->label('IP位址')
                                ->disabled()
                                ->nullable()
                                ->maxLength(30),
                            Forms\Components\TextInput::make('ssid')
                                ->label('SSID')
                                ->disabled()
                                ->nullable()
                                ->maxLength(32),
                        ])->columns(2),

                    ])->after(function (Model $record, array $data) {
                        // Runs after the form fields are saved to the database.
                        $ports = $record->details;

                        $action = $ports->pluck('status', 'port')->toArray();
                        /**
                         * @var \App\Service\IotService $iotService
                         */
                        $iotService = app(\App\Service\IotService::class);
                        $iotService->postDeviceControl(auth()->user(), $record->mac_address, $action);
                    }),
                Tables\Actions\DissociateAction::make()
                    ->hidden(! auth()->user()->hasAnyRole(['super_admin', 'admin'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DissociateBulkAction::make(),
                ]),
            ]);
    }

    /**
     * 覆蓋 DevicePolicy 的 viewAny 方法
     */
    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return true;
    }
}
