<?php

namespace App\Traits;

trait SlugTrait
{
    public function getId(string $value): int
    {
        return explode('-', $value)[0];
    }
}
