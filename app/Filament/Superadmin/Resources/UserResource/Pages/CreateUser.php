<?php

namespace App\Filament\Superadmin\Resources\UserResource\Pages;

use App\Filament\Superadmin\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\AdminAccountCreated;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected string $tempPassword;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->tempPassword = Str::random(12);
        $data['password'] = Hash::make($this->tempPassword);
        $data['must_change_password'] = true;

        return $data;
    }

    protected function afterCreate(): void
    {
        // $password = Str::random(12);
        // $this->record->password = bcrypt($password);
        // $this->record->must_change_password = true;
        // $this->record->save();

        $this->record->assignRole('admin');

        $this->record->notify(new AdminAccountCreated($this->tempPassword));
    }
}
