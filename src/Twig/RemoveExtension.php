<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class RemoveExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('removeExt', [$this, 'removeExt']),
        ];
    }

    public function removeExt(string $input): string
    {
        return preg_replace('/\.\w+$/', '', $input);
    }
}