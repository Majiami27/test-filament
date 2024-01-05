<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = '設定';

    public static function getModelLabel(): string
    {
        return '使用者';
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
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('name')
                        ->label('名稱')
                        ->required()
                        ->maxLength(20),
                    Forms\Components\TextInput::make('email')
                        ->label('E-Mail')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\DateTimePicker::make('email_verified_at')
                        ->label('E-Mail 驗證於')
                        ->nullable(),
                    Forms\Components\Toggle::make('status')
                        ->label('狀態')
                        ->required(),
                ])->columns(2),
                Forms\Components\Section::make([
                    Forms\Components\Select::make('roles')
                        ->label('角色')
                        ->relationship('roles', 'name')->preload(),
                ])->columns(1),
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('password')
                        ->label('密碼')
                        ->password()
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (Page $livewire) => ($livewire instanceof CreateRecord)),
                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('名稱')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-Mail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('E-Mail 驗證於')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('狀態')
                    ->boolean(),
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
