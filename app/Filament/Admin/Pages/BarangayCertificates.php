<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class BarangayCertificates extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static string $view = 'filament.admin.pages.barangay-certificates';

    protected static ?string $title = 'Barangay Certificates'; // This will show in sidebar

    protected static ?string $navigationGroup = 'Forms'; // Same group as BarangayForms
}
