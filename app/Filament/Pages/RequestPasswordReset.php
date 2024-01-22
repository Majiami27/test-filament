<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\PasswordReset\RequestPasswordReset as AuthRequestPasswordReset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Contracts\Support\Htmlable;

class RequestPasswordReset extends AuthRequestPasswordReset
{
    public function getTitle(): string|Htmlable
    {
        return '重設您的密碼';
    }

    public function getHeading(): string|Htmlable
    {
        return '忘記密碼?';
    }

    public function loginAction(): Action
    {
        return Action::make('login')
            ->link()
            ->label('回登入頁面')
            ->icon(match (__('filament-panels::layout.direction')) {
                'rtl' => FilamentIcon::resolve('panels::pages.password-reset.request-password-reset.actions.login.rtl') ?? 'heroicon-m-arrow-right',
                default => FilamentIcon::resolve('panels::pages.password-reset.request-password-reset.actions.login') ?? 'heroicon-m-arrow-left',
            })
            ->url(filament()->getLoginUrl());
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('E-Mail')
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    protected function getRequestFormAction(): Action
    {
        return Action::make('request')
            ->label('寄送重設密碼連結')
            ->submit('request');
    }
}
