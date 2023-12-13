<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileManager
{
    public function ajustUrl(string $value): string
    {
        if (strpos($value, 'http') === 0) {
            return $value;
        } else {
            return Storage::disk('public')->url($value);
        }
    }
}
