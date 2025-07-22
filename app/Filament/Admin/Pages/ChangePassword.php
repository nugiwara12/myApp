<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static string $view = 'filament.admin.pages.change-password';
    protected static ?string $slug = 'change-password'; // <== ensures route is /admin/change-password

    public ?array $formData = [];

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('password')
                ->password()
                ->required()
                ->label('New Password'),

            TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->label('Confirm Password'),
        ])->statePath('formData');
    }

    public function submit(): void
    {
        auth()->user()->update([
            'password' => Hash::make($this->formData['password']),
            'must_change_password' => false,
        ]);

        session()->flash('success', 'Password changed successfully.');

        $this->redirect(route('filament.admin.pages.dashboard'));
    }
}
