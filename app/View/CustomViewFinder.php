<?php

namespace App\View;

use Illuminate\View\FileViewFinder;
use Illuminate\Support\Facades\Log;

class CustomViewFinder extends FileViewFinder
{
    protected function getPossibleViewFiles($name)
    {
        Log::info('CustomViewFinder - Resolving view:', ['view_name' => $name]);

        return array_map(
            fn ($extension) => str_replace('.', '/', $name).'.'.$extension,
            $this->extensions
        );
    }
}
