<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class BarangayIndigency extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-identification'; // Optional: pick icon

    protected static string $view = 'filament.admin.pages.barangay-indigency';

    protected static ?string $title = 'Barangay Indigency'; // Appears in the sidebar

    protected static ?string $navigationGroup = 'Forms'; // 👈 Groups under same dropdown
}
