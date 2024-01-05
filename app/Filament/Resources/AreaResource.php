<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AreaResource\Pages;
use App\Filament\Resources\AreaResource\RelationManagers\DevicesRelationManager;
use App\Filament\Resources\AreaResource\RelationManagers\UsersRelationManager;
use App\Models\Area;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AreaResource extends Resource
{
    protected static ?string $model = Area::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = '組織管理';

    protected static ?string $modelLabel = '場域';

    protected static ?string $pluralModelLabel = '組織管理';

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
                Forms\Components\Section::make('基本資料')
                    ->description('請輸入場域名稱與狀態。')
                    ->disabled(! auth()->user()->hasRole('admin'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('場域名稱')
                            ->maxLength(20),
                        Forms\Components\Toggle::make('status')
                            ->label('場域狀態')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('場域')
                    ->searchable(),
                Tables\Columns\TextColumn::make('devices_count')
                    ->label('設備數量')
                    ->counts('devices'),
                Tables\Columns\TextColumn::make('users_count')
                    ->label('使用者數量')
                    ->counts('users')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('status')
                    ->label('狀態')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('建立時間')
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
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            'users' => UsersRelationManager::class,
            DevicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAreas::route('/'),
            'create' => Pages\CreateArea::route('/create'),
            'edit' => Pages\EditArea::route('/{record}/edit'),
        ];
    }
}
