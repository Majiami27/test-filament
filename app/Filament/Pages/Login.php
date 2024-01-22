<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as AuthLogin;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class Login extends AuthLogin
{
    public function registerAction(): Action
    {
        return Action::make('register')
            ->link()
            ->label('註冊帳號')
            ->url(filament()->getRegistrationUrl());
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/login.form.password.label'))
            ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()">忘記密碼?</x-filament::link>')) : null)
            ->password()
            ->autocomplete('current-password')
            ->required()
            ->extraInputAttributes(['tabindex' => 2]);
    }
}
