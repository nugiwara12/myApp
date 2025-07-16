<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class BarangayId extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string $view = 'filament.admin.pages.barangay-id';

    protected static ?string $title = 'Barangay ID';

    protected static ?string $navigationGroup = 'Forms';
}
