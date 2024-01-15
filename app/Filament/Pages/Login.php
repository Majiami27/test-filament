<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Auth\Login as AuthLogin;

class Login extends AuthLogin
{
    public function registerAction(): Action
    {
        return Action::make('register')
            ->link()
            ->label('註冊帳號')
            ->url(filament()->getRegistrationUrl());
    }
}
