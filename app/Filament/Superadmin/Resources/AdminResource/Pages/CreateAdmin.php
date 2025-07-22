<?php

namespace App\Filament\Superadmin\Resources\AdminResource\Pages;

use App\Filament\Superadmin\Resources\AdminResource;
use App\Notifications\AdminAccountCreated;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    protected function afterCreate(): void
    {
        $password = Str::random(12);
        $this->record->password = bcrypt($password);
        $this->record->must_change_password = true;
        $this->record->save();

        $this->record->assignRole('admin');

        $this->record->notify(new AdminAccountCreated($password));
    }

    protected function getRedirectUrl(): string
    {
        // ✅ Explicitly redirect to the admin resource index within superadmin panel
        return static::$resource::getUrl(name: 'index', panel: 'superadmin');
    }
}
